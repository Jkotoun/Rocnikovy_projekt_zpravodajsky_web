<div class="edit-form-container">
    <h1>Úprava osobních údajů</h1>





    <div class="edit-form-border">
        <?php
        if(isset($form) && $form == "data"):

            if(isset($messages['success'])):
                foreach($messages['success'] as $message) :?>

                    <div class="success-message message"><?=$message?><div class="message-hide"><span class="icon-cross"></span> </div> </div>
                <?php endforeach;endif;?>
            <?php if(isset($messages['errors'])):
            foreach($messages['errors'] as $message) :?>


                <div class="error-message message"><?=$message?><div class="message-hide"><span class="icon-cross"></span> </div> </div>
            <?php endforeach; endif;endif;?>
        <form class="edit-form" enctype="multipart/form-data" method="post" action="nastaveni/edit">
                <h5>Profilový obrázek</h5>
                <label for="profile-picture" class="edit-profile-picture">
                    <img src="public/uploads/profile-pictures/<?=$user['profile_picture']?>" alt="profilový_obrázek" id="profile-picture-img">
                    <i class="icon-new profile-picture-edit-icon"></i>
                </label>
                <input type="file" id="profile-picture" name="profile-picture">
            <h5>Osobní informace</h5>
            <div class="two-inputs custom-label">
                <div class="row">
                    <div class="col-sm-6 label-input-group">
                        <input type="text" placeholder="Jméno" class="form-control" id="name" name="name" value="<?=$user['first_name']?>">
                        <label for="name">Jméno</label>
                        <div class="form-error-text"> </div>
                    </div>
                    <div class="col-sm-6 label-input-group">
                        <input type="text" placeholder="Příjmení" class="form-control" id="surname" name="surname" value="<?=$user['last_name']?>" >
                        <label for="surname">Příjmení</label>
                        <div class="form-error-text"> </div>
                    </div>
                </div>
            </div>
            <div class="two-inputs custom-label">
                <div class="row">
                    <div class="col-sm-6 label-input-group">
                        <input type="email" placeholder="Emailová adresa" class="form-control" id="email" name="email" value="<?=$user['email']?>" >
                        <label for="email">Emailová adresa</label>
                        <div class="form-error-text"> </div>
                    </div>
                    <div class="col-sm-6 label-input-group">
                        <input type="text" placeholder="text" class="form-control" id="profile_url" name="profile_url" value="<?=$user['profile_url']?>" >
                        <label for="url">URL adresa profilu</label>
                        <div class="form-error-text"> </div>
                    </div>
                </div>
            </div>
            <div class="form-group textarea-group">
                <label for="about">Informace o Vás</label>
                <textarea name="about" id="about"><?=$user['about']?></textarea>
            </div>
            <div class="form-group age">
                <label id="birth-date">Datum narození</label>
                <div class="row">
                    <div class="col-sm-4 select-wrapper">
                        <label for="birthday-date">Den</label>
                        <select class="selectpicker" name="birthday-day" id="birthday-day">
                            <?php for ($i = 1; $i <= 31; $i++) echo($i == $user['birth_date'][2] ? '<option selected>'  . $i . '</option>' : '<option>'  . $i . '</option>')?>
                        </select>
                    </div>
                    <div class="col-sm-4 select-wrapper">
                        <label for="birthday-month">Měsíc</label>
                        <select class="selectpicker" name="birthday-month" id="birthday-month">
                            <?php for ($i = 1; $i <= 12; $i++) echo($i == $user['birth_date'][1] ? '<option selected>'  . $i . '</option>' : '<option>'  . $i . '</option>') ?>
                        </select>
                    </div>
                    <div class="col-sm-4 select-wrapper">
                        <label for="birthday-year">Rok</label>
                        <select class="selectpicker" name="birthday-year" id="birthday-year">
                            <?php
                            $current_year = date("Y");
                            for ($year = $current_year; $year >= $current_year - 100; $year--)  echo($year == $user['birth_date'][0] ? '<option selected>'  . $year . '</option>' : '<option>'  . $year . '</option>') ?>
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-error-text"> </div>
            </div>
            <div class="form-group">
                <label class="gender-label" >Pohlaví</label>
                <div class="radio-option">
                    <input type="radio"<?php if($user['gender'] == "Muž") {echo('checked');} ?> name="gender" id="male" value="Muž">
                    <label for="male"><span class="styled-radio"></span> Muž</label>
                </div>
                <div class="radio-option">
                    <input type="radio"  <?php if($user['gender'] == "Žena"){ echo('checked');}?> name="gender" id="female" value="Žena" >
                    <label for="female"><span class="styled-radio"></span> Žena</label>
                </div>
                <div class="form-error-text"> </div>
            </div>
            <button type="submit" class="btn btn-blue" >Uložit</button>
        </form>
    </div>
</div>
<div class="login-form-container">
    <h1>Změna hesla</h1>

    <div class="login-form-border" id="password-form">
        <?php if(isset($form)  && $form == "password" ):

            if(isset($messages['success'])):
                foreach($messages['success'] as $message) :?>

                    <div class="success-message message"><?=$message?><div class="message-hide"><span class="icon-cross"></span> </div> </div>
                <?php endforeach;endif;?>
            <?php if(isset($messages['errors'])):
            foreach($messages['errors'] as $message) :?>


                <div class="error-message message"><?=$message?><div class="message-hide"><span class="icon-cross"></span> </div> </div>
            <?php endforeach; endif;endif;?>
        <form class="password-change-form" method="post" action="nastaveni/password#password-form">
            <div class="login-form-inputs">
                <div class="form-group custom-label">
                    <input type="password" placeholder="Heslo" class="form-control" name="old-password" id="old-password">
                    <label for="old-password">Staré heslo</label>
                    <div class="form-error-text"> </div>
                </div>
                <div class="form-group custom-label">
                    <input type="password" placeholder="Heslo" class="form-control" name="password-new" id="password-new">
                    <label for="password">Nové heslo</label>
                    <div class="form-error-text"> </div>
                </div>
                <div class="form-group custom-label">
                    <input type="password" placeholder="Heslo2" class="form-control" name="password2" id="password2">
                    <label for="password2">Nové heslo znovu</label>
                    <div class="form-error-text"> </div>
                </div>
            </div>
            <button type="submit" class="btn btn-blue" >Uložit</button>
        </form>
    </div>
</div>