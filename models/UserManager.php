<?php

class UserManager
{
    public static function getLoggedUser()
    {
        if (isset($_SESSION['user']))
            return $_SESSION['user'];
        return null;
    }
    public function UsersInfo($count, $offset)
    {
        return Database::queryAll('
        select first_name, last_name, email, profile_picture, profile_url, user_role, user_id
        from users
        LIMIT ? OFFSET ?
        ',array($count,$offset));
    }
    public function getUserById($user_id)
    {
        return Database::queryOne('
            SELECT *
            from users as u
            where user_id = ?
        ', array($user_id));
    }
    public function SearchUser($search)
    {
        return Database::queryAll('
        select first_name, last_name, email, profile_picture, profile_url, user_role, user_id
        from users
        where CONCAT(first_name," ",last_name) LIKE ?  
        ',array($search . "%"));
    }
    public function UsersCount()
    {
        return Database::query('
        select *
        from users
        ');
    }
    public function getUserByUrl($user_url)
    {
        return Database::queryOne('
            SELECT *
            from users as u
            where profile_url = ?
        ', array($user_url));
    }

    public function updateLoggedUserData($data, $user_id)
    {
        try {
            Database::update('users', $data, 'where user_id = ?', array($user_id));
            $_SESSION['user'] = $this->getUserById($user_id);
        } catch (PDOException $error) {

            if(strpos($error->getMessage(),'profile_url'))
            {
                throw new Exception("Tuto URL adresu profilu již využívá někdo jiný");
            }
            else
            {
                throw new Exception("Tento email již někdo používá");
            }

        }
    }
    public function updateUserData($data, $user_id)
    {
        try {
            Database::update('users', $data, 'where user_id = ?', array($user_id));

        } catch (PDOException $error) {
            throw new Exception("Akce se nepovedla");

        }
    }

    public function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function login($email, $password)
    {
        $user = Database::queryOne('
        select *
        from users
        where email = ?
        ', array($email));
        if (!$user || !password_verify($password, $user['password'])) {
            throw new Exception('Špatné jméno nebo heslo');
        }
        $_SESSION['user'] = $user;
    }

    public function register($first_name, $last_name, $email, $password, $day, $month, $year, $gender)
    {


        if($gender=='Muž')
        {
            $profile_picture = "male-default.png";
        }
        else
        {
            $profile_picture = "female-default.png";
        }
        $user = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'birth_date' => $year . "-" . $month . "-" . $day,
            'email' => $email,
            'profile_picture'=>$profile_picture,
            'gender' => $gender,
            'password' => $this->hash($password)
        );
        try {
            Database::insert('users', $user);
        } catch (PDOException $error) {
            throw new Exception('Tento email je již použitý pro jiný účet');
        }
    }

    public function changePassword($password, $user_id)
    {
        try {
            $password['password'] = $this->hash($password['password']);
            Database::update('users', $password, 'where user_id=?', array($user_id));
            $_SESSION['user'] = $this->getUserById($user_id);
        } catch (PDOException $error) {
            throw new Exception('Uživatel neexistuje');
        }
    }
    public function userArticlesCount($user_id)
    {
        return Database::query('
        select * 
        from articles 
        where author_id = ?
        ',array($user_id));
    }
    public function removeUser($user_id)
    {        $users_comments =
        Database::queryAll('
        Select comment_id
        from comments
        where author_id = ?
        ', array($user_id));

        foreach($users_comments as $comment)
        {
            Database::query('
       Delete 
       from comments
        where reply_to = ?
       ',array($comment['comment_id']));
        }

        Database::query('
        Delete 
        from users
        where user_id = ?
        ', array($user_id));



        Database::query('
        Delete 
        from comments
        where author_id = ?
        ', array($user_id));

        Database::query('
        Delete from articles
        where author_id = ?
        ',array($user_id));

        Database::query('
        Delete from comments_rating
        where user_id = ?
        ',array($user_id));





    }
    public function logout()
    {
        unset($_SESSION['user']);
    }
}
