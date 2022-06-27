<!DOCTYPE html>
<html>
    <head>
        <title> Buhalterinė apskaita </title>
        <link rel='stylesheet' href='css/new-style.css'>
        <link rel='stylesheet' href='css/style.css'>
        <link rel='icon' href='images/icon.png'>
    </head>
    <body>
        <nav class="navigation">
            <h1 class="web-name">Namų ūkio buhalterinė apskaita</h1>
            <form action='controller/login.php' method ='POST'>
                <ul class="items login-items">
                    <input type="text" class ='login-input' placeholder="vartotojo vardas" name = 'username'>
                    <input type="password" class ='login-input' placeholder="slaptažodis"  name = 'password'>
                    <input type="submit" class ='button login-button' value="prisijungti" name = 'submit'>
                    <a class='reg-button'>Registruotis</a>
                </ul>
            </form>
            <div class="burger">
                <div class="burger-line"></div>
                <div class="burger-line"></div>
                <div class="burger-line"></div>
            </div>
        </nav>

        <main>      
            <form class = 'registration' id='regform' action='controller/registration.php' method ='POST'>
                <h1 class='registration-title'> Registracija </h1>
                    <input type="text" class ='' placeholder="Vardas" name='vardas'>
                    <input type="text" class ='' placeholder="Pavardė" name='pavarde'>
                    <input type="text" class ='' placeholder="Vartotojo vardas" name='username'>
                    <input type="text" class ='' placeholder="Asmens kodas" name='kodas'>
                    <input type="password" class ='' placeholder="Slaptažodis" name='password'>
                    <input type="password" class ='' placeholder="Pakartotinas slaptažodis" name='repeatPassword'>
                    <div>
                    <label for="">statusas:</label>
                    <select  name='statusas'>
                        <option value='Suages'>Suages</option>
                        <option value='Vaikas'>Vaikas</option>
                    <select>
                    </div>

                    <input type="submit" class ='button' value="Registruotis"  name = 'submit'>
            </form>
        </main>


        <script src='js/scipt-style.js'></script> 
        <script src='js/registration-script.js'></script> 
    </body>

</html>