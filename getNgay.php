<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
      <div id="ngay">

      </div>
      <form id='target'  action="napNgay.php" method='post' hidden>
            <input type="text" id='ngayThang' name='ngayThang'>
            <input type="submit" value="Go">
      </form>
      <script>
            $(document).ready(function () {
                  $('#data').hide();
                  $.get('https://www.thoigian.com.vn/',function(data){
                        var res = $.parseHTML(data);
                        $(res).find('td#m604').each(function(){
                              let ngay = $(this).html();
                              let ngay1 = ngay.replace('<b>Bát tự: </b>','');
                              let ngay2 = ngay1.trim()
                              let ngay3 = ngay2.split(', ');
                              let ngay4 = [];
                              ngay3.forEach((item, index) =>{
                                    let a = item.split(' ');
                                    let b = a.splice(1);
                                    let c = b.join(' ')
                                    ngay4.push(c) 
                                   
                              })
                              
                              console.log(ngay4)
                              $('#ngay').append($(this).html());
                              $('#ngayThang').val(JSON.stringify(ngay4))
                              $('#target').submit()

                        });
                  });
                  // setTimeout(() => {
                  //       window.location = 'index.php'
                  // }, 1000);
            });
      </script>
</body>
</html>