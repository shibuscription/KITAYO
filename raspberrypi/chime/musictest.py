import binascii
import nfc
import MySQLdb
import pygame.mixer


class MyCardReader(object):

    def on_connect(self, tag):
        if tag.type != 'Type3Tag':
            return True
        
        self.idm = binascii.hexlify(tag.idm)

        connector = MySQLdb.connect(host="192.168.0.8", db="cathy", user="cathy", passwd="cathy", charset="utf8")
        cursor = connector.cursor()
        sql = u"insert into idms values('" + self.idm + "', SYSDATE())"
        cursor.execute(sql)
        connector.commit()
        cursor.close()
        connector.close()
        
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
