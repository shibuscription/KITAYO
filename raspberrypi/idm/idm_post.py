import binascii
import json
import nfc
import requests
import pygame.mixer


def get_device_id():
    try:
        with open('/proc/cpuinfo', 'r') as f:
            for line in f:
                if line.startswith('Serial'):
                    return line.strip().split(': ')[1][-8:]  # 下8桁だけ使う
    except Exception as e:
        return "unknown"


# 設定読み込み
with open('config.json', 'r') as f:
    config = json.load(f)

API_URL = config["api_url"]
DEVICE_ID = get_device_id() if config.get("device_id") == "auto" else config.get("device_id")


class MyCardReader(object):

    def on_connect(self, tag):
        if tag.type != 'Type3Tag':
            return True

        idm = binascii.hexlify(tag.idm).decode()
        print("読み取ったIDm: {}".format(idm))
        print("端末ID（device_id）: {}".format(DEVICE_ID))

        payload = {
            "idm": idm,
            "device_id": DEVICE_ID
        }

        try:
            response = requests.post(API_URL, json=payload)
            print("APIレスポンス:", response.text)
        except Exception as e:
            print("APIエラー:", e)

        pygame.mixer.init()
        pygame.mixer.music.load('idm.wav')
        pygame.mixer.music.play()

        return True

    def read_id(self):
        clf = nfc.ContactlessFrontend('usb')
        try:
            clf.connect(rdwr={'on-connect': self.on_connect})
        finally:
            clf.close()


if __name__ == '__main__':
    cr = MyCardReader()
    while True:
        cr.read_id()

