<div class="login-form-container">
    <h1>Registrace</h1>
    <div class="login-form-border">


        <form class="register-form" method="post">
            <div class="login-form-inputs">
                <div class="form-group custom-label name-input-container">
                    <input type="text" placeholder="Jméno" class="form-control" id="name" name="name">
                    <label for="name">Jméno</label>
                    <div class="form-error-text"> </div>
                </div>
                <div class="form-group custom-label surname-input-container">
                    <input type="text" placeholder="Příjmení" class="form-control" id="surname" name="surname">
                    <label for="surname">Příjmení</label>
                    <div class="form-error-text"> </div>
                </div>
                <div class="form-group custom-label email-input-container">
                    <input type="email" placeholder="Emailová adresa" class="form-control" id="email" name="email">
                    <label for="email">Emailová adresa</label>
                    <div class="form-error-text"> </div>
                </div>
                <div class="form-group custom-label password-input-container">
                    <input type="password" placeholder="Heslo" class="form-control" id="password-new" name="password">
                    <label for="password">Heslo</label>
                    <div class="form-error-text"> </div>
                </div>
                <div class="form-group custom-label password2-input-container">
                    <input type="password" placeholder="Ověření hesla" class="form-control" id="password2">
                    <label for="password2">Potvrďte heslo</label>
                    <div class="form-error-text"> </div>
                </div>
            </div>

            <div class="form-group age age-input-container">
                <label id="birth-date">Datum narození</label>
                <div class="row">
                    <div class="col-sm-4 select-wrapper">
                        <label for="birthday-day">Den</label>
                        <select class="selectpicker" id="birthday-day" name="birthday-day">
                            <?php for ($i = 1; $i <= 31; $i++) echo('<option>' . $i . '</option>') ?>
                        </select>
                    </div>
                    <div class="col-sm-4 select-wrapper">
                        <label for="birthday-month">Měsíc</label>
                        <select class="selectpicker" id="birthday-month" name="birthday-month">
                            <?php for ($i = 1; $i <= 12; $i++) echo('<option>' . $i . '</option>') ?>
                        </select>
                    </div>
                    <div class="col-sm-4 select-wrapper">
                        <label for="birthday-year">Rok</label>
                        <select class="selectpicker" id="birthday-year" name="birthday-year">
                            <?php
                            $current_year = date("Y");
                            for ($year = $current_year; $year >= $current_year - 100; $year--) echo('<option>' . $year . '</option>') ?>
                        </select>
                    </div>

                </div>
                <div class="form-error-text"> </div>
            </div>
            <div class="form-group gender-input-container">
                <label class="gender-label">Pohlaví</label>
                <div class="radio-option">
                    <input type="radio" checked name="gender" id="male" value="Muž">
                    <label for="male"><span class="styled-radio"></span> Muž</label>
                </div>
                <div class="radio-option">
                    <input type="radio" name="gender" id="female" value="Žena">
                    <label for="female"><span class="styled-radio"></span> Žena</label>
                </div>
                <div class="form-error-text"></div>
            </div>

            <button type="submit" class="btn btn-blue register-button">
                <span class="register-button-text"> Registrovat</span>
            </button>
            <div class="login-form-link">Již u nás máte účet? <a href="prihlaseni">Přihlaste se!</a></div>
        </form>

    </div>
</div>