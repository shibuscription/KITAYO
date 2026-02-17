<style>
  body{
    background:#0b1220;
    color:#eaf0ff;
  }
  .wrap{
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    flex-direction:column;
    gap:16px;
  }
  .check{
    font-size:96px;
    line-height:1;
  }
  .msg{
    font-size:28px;
    font-weight:700;
  }
  .sub{
    opacity:.8;
    font-size:16px;
  }
</style>

<div class="wrap">
  <div class="check">✔</div>
  <div class="msg"><?= h($message) ?></div>
  <div class="sub">
    <span id="sec">3</span> 秒後に待ち画面へ戻ります
  </div>
</div>

<script>
let sec = 3;
const secEl = document.getElementById('sec');

const timer = setInterval(() => {
  sec--;
  secEl.textContent = sec;
  if (sec <= 0) {
    clearInterval(timer);
    location.href = '/dashboard/index';
  }
}, 1000);
</script>
