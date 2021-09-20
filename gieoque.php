<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <link rel="stylesheet" href="style.css?v=<?= microtime() ?>">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <title>Gieo Quẻ</title>
</head>
<body>
      <h3><b>Gieo quẻ</b></h3>
      <label for="chon">Chọn cách gieo quẻ: </label>
      <select name="chon" id="chon">
            <option value="maiHoa">Mai Hoa</option>
            <option value="lucHao">Lục Hào</option>
      </select>
      <hr>
      <div class='row'>
            <div class="col" id="maiHoa">
                  sdf
            </div>
            <div class="col" id="lucHao">
                  jkj
            </div>
      </div>

</body>
</html>

<script>
      $(document).ready(function () {
            $('#lucHao').hide()
            $('#chon').on('change',function(){
                  if($(this).val() == 'maiHoa'){
                        $('#maiHoa').show()
                        $('#lucHao').hide()
                  }else if($(this).val() == 'lucHao'){
                        $('#maiHoa').hide()
                        $('#lucHao').show()
                  }
            })
      });
</script>