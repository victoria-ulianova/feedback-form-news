<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name ="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link href="mystyle.css" rel="stylesheet"/>
    <link href="adaptive.css" rel="stylesheet"/>

    <script>
        var personArray = [];

        function init(){
            document.getElementById("tablerows").innerHTML = "";
           if(localStorage.personRecord){
               personArray = JSON.parse(localStorage.personRecord);
               for(var i=0; i<personArray.length; i++){

                   prepareTableCell(i,personArray[i].firstname,personArray[i].address,personArray[i].telephone,personArray[i].email);

               }
           }
        }

        function onRegisterPressed(){

            var FirstName = document.getElementById("firstname").value;
            var Address = document.getElementById("address").value;
            var Telephone = document.getElementById("telephone").value;
            var Email = document.getElementById("email").value;

            var persObj = {firstname:FirstName,address:Address,telephone:Telephone,email:Email};
            personArray.push(persObj);

            localStorage.personRecord = JSON.stringify(personArray);

            init();

            //clear fields

            document.getElementById("firstname").value ="";
            document.getElementById("address").value ="";
            document.getElementById("telephone").value ="";
            document.getElementById("email").value ="";

        }
        function prepareTableCell(index,FirstName,Address,Telephone,Email){
            var table = document.getElementById("tablerows");
            var row = table.insertRow();
            var FirstNameCell = row.insertCell(0);
            var AddressCell = row.insertCell(1);
            var TelephoneCell = row.insertCell(2);
            var EmailCell = row.insertCell(3);
            var ActionCell = row.insertCell(4);

            FirstNameCell.innerHTML = FirstName;
            AddressCell.innerHTML = Address;
            TelephoneCell.innerHTML = Telephone;
            EmailCell.innerHTML = Email;
            ActionCell.innerHTML = '<button onclick="deleteTableRow('+index+')">Удалить</button>';

        }
        function deleteTableRow(index){
            var table = document.getElementById("regtable");
            table.deleteRow(index+1);
            personArray.splice(index,1);
            localStorage.personRecord = JSON.stringify(personArray);
            init();
        }
    </script>

</head>
<body onload = "init()">
    <div class ="container">
        <div class = "block">
        <aside class="leftbar"><h1>Заполните форму:</h1>
            <form>
            <div>
                <fieldset>
                    <label for="firstname" class="labelwidth"><span>Имя</span></label>
                    <input type="text" placeholder=" ваше имя* " data-validate-field='firstname' id="firstname" name="firstname" required  title="Требуется вводить только буквы и не меньше одной"  pattern="\D[^0-9][A-Za-zА-Яа-яЁё]{1,}">
                </fieldset>
                <fieldset>
                    <label for="address" class="labelwidth">Адрес</label>
                    <input type="text" placeholder=" адрес сайта" id="address">
                </fieldset>
                <fieldset>
                    <label for="telephone" class="labelwidth">Телефон</label>
                    <input type="tel"  placeholder=" контактный телефон* "  data-validate-field='tel' id="telephone" name="tel"  required>
                </fieldset>
                <fieldset>
                    <label for="email" class="labelwidth">E-mail</label>
                    <input type="text" placeholder=" электронная почта " id="email" name="email" >
                </fieldset>
                <fieldset>
                    <label for="submit" class="labelwidth">&nbsp;</label>
                    <button type="submit" id="submit" class = "file_button" onclick="onRegisterPressed()">Отправить</button>
                </fieldset>
            </div>
            </form>
        </aside>
        <aside class="rightbar">
            <table id="regtable" class="regtable">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Адрес</th>
                    <th>Телефон</th>
                    <th>E-mail</th>
                    <th>Редактор</th>
                </tr>
                </thead>
                <tbody id="tablerows">
                </tbody>
            </table>
        </aside>
        <footer class="headerbar bottom"></footer>
    </div>
    </div>
 <div class="prokrutka">
   <div class="containertwo">
       <div class="list-wrapper">
           <?php
                if(file_exists('news.json')){
                    $api_url = 'news.json';
                    $newslist = json_decode(file_get_contents($api_url));
                }else {
                    $api_url = 'https://newsapi.org/v2/top-headlines?country=ru&apiKey=3d1c922949214e8796ddda124b1ba269';
                    $newslist = file_get_contents($api_url);
                    file_get_contents('news.json', $newslist);
                    $newslist = json_decode($newslist);
                }

            foreach ($newslist->articles as $news){?>

           <div class="row single-news">
               <div class="col-4">
                  <img style="width:100%;" src="<?php echo $news->urlToImage;?>" alt="">
               </div>
               <div class="col-8">
                   <h2><?php echo $news->title;?></h2>
                   <small><?php echo $news->source->name;?></small>
                   <?php if($news->author && $news->author!=''){ ?>
                   <small>|  <?php echo $news->author;?></small>
                   <?php } ?>
                   <p><?php echo $news->description;?></p>
                   <a href="<?php echo $news->url;?>" class="btn btn-sm btn-primary" style="float: right;" target="_blank">Read More>></a>
               </div>
           </div>
               <?php } ?>
       </div>
   </div>
</div>

    <script src="inputmask.min.js"></script>
    <script src="form.js"></script>

</body>
</html>
