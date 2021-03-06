<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Tv-guiden</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/minireset.css@0.0.3/minireset.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="flex flex-column">
  <header class="py-7 px-5 bg-1">
    <div class="container-1">
      <h1 class="centered color-white text-8 text-shadow-2">TV-guiden</h1>
    </div>
  </header>
  <section class="bg-3-light p-5 flex-1">
    <div class="container-1 fullheight">
      <form method="get" id="channels" class="flex align-center fullheight mx--7 flex-wrap">
        <div class="flex-1 order-1 mx-7">
          <div class="bg-white shadow mb-5">
            <div class="bb-1-gray p-1 flex justify-between align-center">
              <h2 class="text-4 bold">Välj datum (yyyy-mm-dd)</h2>
              <button class="b-none shadow bg-1-light rounded-2 color-white py-.9 px-1 pointer text-2" onclick="setToday(event)">Idag</button>
            </div>
            <div class="centered">
              <input
                class="text-4 py-1 px-2 b-2-gray width-11 centered rounded-2 my-2"
                style="box-shadow: none;"
                type="date"
                pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])"
                id="date"
                name="date"
                value="<?= $date ?>"
              >
            </div>
          </div>
          <div class="flex flex-column align-center bg-white shadow py-2 mb-5">
            <button class="b-none width-11 shadow bg-1-light rounded-2 color-white p-2 m-2 pointer text-4" formaction="/xml" formtarget="_blank">Visa som XML</button>
            <button class="b-none width-11 shadow bg-yes rounded-2 color-white p-2 m-2 pointer text-4" formaction="/xhtml" formtarget="_blank">Visa som XHTML</button>
            <button class="b-none width-11 shadow bg-2 rounded-2 color-white p-2 m-2 pointer text-4" formaction="/TV-guide.pdf" formtarget="_blank">Visa som PDF</button>
          </div>
        </div>
        <div class="flex-1 bg-white shadow mx-7 mb-5">
          <div class="bb-1-gray p-1 flex justify-between align-center">
            <h2 class="text-4 bold">Välj kanaler</h2>
            <input class="flex-1 mx-1 fullwidth rounded-2 b-2-gray text-2 p-1" placeholder="Sök" oninput="filterChannels(event)">
            <button class="b-none shadow bg-1-light rounded-2 color-white py-.9 px-1 pointer text-2" onclick="resetCheckboxes(event)">Rensa val</button>
          </div>
          <ul class="scroll-y" style="height: 50vh;">
            <?php foreach ($channels as $channel) : ?>
              <li class="channel-item">
                <label class="bb-1-gray flex align-center">
                  <img
                    style="line-height: 1.2;"
                    class="bg-gray-light width-5 height-5 rounded-2 ml-3 text-5"
                    src="http://chanlogos.xmltv.se/<?= $channel ?>.png"
                    alt="📺"
                  >
                  <div class="channel-name m-3 lh-1 flex-1"><?= $channel ?></div>
                  <input class="m-3" name="channels[]" value="<?= $channel ?>" type="checkbox">
                </label>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </form>
    </div>
  </section>
  <script>
  function resetCheckboxes(event) {
    event.preventDefault()
    document.querySelectorAll('#channels input[type=checkbox]').forEach(a => a.checked = false)
  }
  function setToday(event) {
    event.preventDefault()
    document.getElementById('date').value = new Date().toISOString().slice(0,10)
  }
  function filterChannels(event) {
    // event.preventDefault();
    document.querySelectorAll('.channel-item').forEach(channel => {
      if (channel.querySelector('.channel-name').textContent.indexOf(event.target.value) !== -1) {
        channel.classList.remove('hidden')
      } else {
        channel.classList.add('hidden')
      }
    })
  }
  </script>
</body>
</html>
