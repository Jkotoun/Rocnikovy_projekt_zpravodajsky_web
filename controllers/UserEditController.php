<?php

class UserEditController extends controller
{
    public function process($params)
    {
        $userManager = new UserManager();
        $user = $userManager->getLoggedUser();

        if (!$user) {
            $this->redirect('prihlaseni');
        }
        if ($_POST) {

            if($params[0] == 'edit')
            {
                $this->data['form'] = 'data'; //kvůli scrollování po odeslání

                $data = array(
                    'first_name' => $_POST['name'],
                    'last_name' => $_POST['surname'],
                    'email' => $_POST['email'],
                    'about' => $_POST['about'],
                    'profile_url'=> $_POST['profile_url'],
                    'birth_date' => $_POST['birthday-year'] . "-" . $_POST['birthday-month'] . "-" . $_POST['birthday-day'],
                    'gender' => $_POST['gender']
                );

                try {
                    if(preg_match('/[^A-Za-z0-9-]/',$_POST['profile_url']))
                    {
                        throw new Exception("Nepovolené znaky");
                    }
                    if(!empty($_FILES['profile-picture']['name']))
                    {
                        if(file_exists("public/uploads/profile-pictures/". $_FILES['profile-picture']['name']))
                        {
                            $addition = 1;
                            $file_name_array = explode(".",$_FILES['profile-picture']['name']);
                            $name = $file_name_array[0];
                            while(file_exists("public/uploads/profile-pictures/" . $name . ".". $file_name_array[1]))
                            {
                                $name = $file_name_array[0] . $addition;
                                $addition++;
                            }
                            $_FILES['profile-picture']['name']  = $name. "." . $file_name_array[1];
                        }
                        $data['profile_picture'] = $_FILES['profile-picture']['name'];
                        $contentManager = new ContentManager();
                        $contentManager->uploadImage("public/uploads/profile-pictures/", $_FILES["profile-picture"],250,250);
                    }
                    else {

                        if ($user['profile_picture'] ==='male-default.png'|| $user['profile_picture'] === 'female-default'){

                        if ($_POST['gender'] == 'Muž') {
                            $profile_picture = "male-default.png";
                        } else {
                            $profile_picture = "female-default.png";
                        }
                        $data['profile_picture'] = $profile_picture;
                    }

                    }
                    $userManager->updateLoggedUserData($data, $user['user_id']);
                    $this->addSuccess('Změny byly úspěšně uloženy');

                } catch (Exception $error) {
                    $this->addError($error->getMessage());
                }
                $user = $userManager->getLoggedUser();

            }
            else if($params[0]=='password') {
                $this->data['form'] = 'password';
                try
                {
                    if(!password_verify($_POST['old-password'],$user['password'])) {
                        throw new Exception('Vaše původní heslo nesouhlasí se zadaným');
                    }
                    $userManager->changePassword(array('password'=>$_POST['password-new']),$user['user_id']);
                    $this->addSuccess('Vaše heslo bylo úspěšně změněno');

                }
                catch (Exception $error)
                {
                    $this->addError($error->getMessage());
                }
                $user = $userManager->getLoggedUser();
            }
        }
        $this->head = array(
            'title' => 'Upravit uživatelský profil',
            'description' => 'úprava uživatelského profilu',
            'keywords' => 'upravit',
            'scripts' => array('navbar-toggling' => 'navbar-scripts.js', 'forms' => 'Forms.js')

        );
        $this->view = 'profile_edit';
        $birth_date = explode('-', $user['birth_date']);
        $user['birth_date'] = $birth_date;
        $this->data['user'] = $user;
        $this->data['messages'] = $this->getMessages();


    }
}