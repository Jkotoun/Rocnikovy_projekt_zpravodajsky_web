<?php

class ContentManager
{
    public function getArticle($url)
    {
        $article =  Database::queryOne('
                        SELECT *
                        FROM articles
                        INNER JOIN users ON author_id = user_id
                        WHERE url = ?
                ', array($url));
        return $article;
    }
    public function ArticlesCount()
    {
        return Database::query('
        select *
        from articles
        ');
    }

    public function searchArticles($search)
    {
        return Database::queryAll('
        select a.title, u.first_name, u.last_name, c.category_name, a.post_time, a.url
        from articles as a
        inner join categories as c on a.category_id=c.category_id
        inner join users as u on a.author_id = u.user_id
        where a.title LIKE ?
         ',array('%'.$search.'%'));
    }
    public function ArticlesInfo($count, $offset)
    {
        return Database::queryAll('
        select a.title, u.first_name, u.last_name, c.category_name, a.post_time, a.url
        from articles as a
        inner join categories as c on a.category_id=c.category_id
        inner join users as u on a.author_id = u.user_id
        order by a.post_time desc 
        LIMIT ? OFFSET ?
        ',array($count,$offset));
    }
    private function strip_tags_content($text, $tags = '') {
        preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
        $tags = array_unique($tags[1]);
        return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
    }
    public function getUsersComments($author_id, $count, $offset)
    {
        $commented_articles = Database::queryAll('
        select article_id, title, url
        from comments as c
        inner join articles as a on Id = article_id
        where c.author_id = ?
        group by article_id
        order by a.post_time desc
        LIMIT ? OFFSET ?
        ',array($author_id, $count, $offset));

        foreach($commented_articles as $key => $value)
        {
            $commented_articles[$key]['comments'] = Database::queryAll('
            select c.comment_id, c.content, c.post_time, u.first_name, u.last_name, u.profile_url, u.profile_picture, c.parent_comment, c.reply_to
            from comments as c 
            inner join users as u on author_id = user_id
            where article_id = ? and author_id = ?
            order by post_time desc 
            ',array($value['article_id'],$author_id));


            foreach($commented_articles[$key]['comments'] as $key2 =>$value2)
            {
                $commented_articles[$key]['comments'][$key2]['post_time'] = $this->singleDateFormat($commented_articles[$key]['comments'][$key2]['post_time']);
                if($commented_articles[$key]['comments'][$key2]['parent_comment']!=null)
                {
                    $reply_to_author = Database::queryOne('
                select first_name, last_name, profile_url
                from comments
                inner join users on user_id = author_id
                where comment_id = ?
                ',array($commented_articles[$key]['comments'][$key2]['reply_to']));
                    $commented_articles[$key]['comments'][$key2]['reply_to_author'] = $reply_to_author['first_name'] . " " . $reply_to_author['last_name'];
                    $commented_articles[$key]['comments'][$key2]['reply_to_link'] = $reply_to_author['profile_url'];
                    $commented_articles[$key]['comments'][$key2]['content'] = strip_tags($this->strip_tags_content($commented_articles[$key]['comments'][$key2]['content'],'<a>',true));
                }
            }
        }

        return $commented_articles;
    }
    public function removeArticle($url)
    {
        Database::query('
        Delete from articles
        where url=?
        ',array($url));
    }
    public function getArticles($offset, $limit)
    {
        $articles = Database::queryAll('
                        SELECT u.first_name, u.last_name, u.profile_picture,u.profile_url, a.title, a.description, a.url, a.img_url,a.post_time, c.category_name
                        FROM articles as a 
                        INNER JOIN users as u ON author_id = user_id
                        INNER JOIN categories as c ON a.category_id = c.category_id
                        order by a.post_time desc
                        LIMIT ? OFFSET ?
                ', array($limit, $offset));
        return ($this->arrayDateFormat($articles, 'post_time'));
    }
    public function CategoryNameByUrl($url)
    {
        return Database::queryOne('
            SELECT category_name
            FROM categories
            where category_url = ?
        
        ', array($url));
    }
    public function CategoryNameById($id)
    {
        return Database::queryOne('
            SELECT category_name
            FROM categories
            where category_id = ?
        
        ', array($id));
    }
    public function AllCategories()
    {
        return Database::queryAll('
            SELECT *
            FROM categories
        
        ');
    }
    public function CategoryId($name)
    {
        return Database::queryOne('
            SELECT category_id
            FROM categories
            where category_name= ?
        
        ', array($name));
    }
    public function category_exists($category)
    {
        $count = Database::query('
        SELECT *
        from categories
        where category_url = ?
        ',array($category));
        if($count==0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    public static function commentIsReply($comment_id)
    {
        $comment = Database::query('
        select * 
        from comments
        where comment_id = ? and parent_comment is not null        
        ',array($comment_id));
        if($comment)
        {
            return true;
        }
        return false;
    }
    public function getArticlesByCategory($offset, $limit, $category_name)
    {
        $articles = Database::queryAll('
                        SELECT u.first_name, u.last_name, u.profile_picture, a.title, a.description, a.url, a.img_url, a.post_time, u.profile_url
                        FROM articles as a
                        INNER JOIN users as u ON author_id = user_id
                        INNER JOIN categories as c ON a.category_id = c.category_id
                        WHERE c.category_url = ?
                        order by a.post_time desc
                        LIMIT ? OFFSET ?
                ', array($category_name, $limit, $offset));
        return ($this->arrayDateFormat($articles, 'post_time'));
    }
    public function commentAuthor($comment_id)
    {
        return Database::queryOne('
        SELECT author_id 
        from comments
        where comment_id = ?
        ', array($comment_id));
    }
    public function RateComment($comment_id,$user_id, $rating)
    {
        return Database::query('INSERT INTO comments_rating (user_id, comment_id, rating)
         	   VALUES (?,?,?) 
         	   ON DUPLICATE KEY UPDATE rating= ?'
        ,array($user_id,$comment_id, $rating, $rating));
    }
    public function RemoveCommentRating($comment_id,$user_id)
    {
        Database::query('
        Delete 
        from comments_rating
        where user_id = ? and comment_id = ?
        ', array($user_id, $comment_id));
    }
    public function rating_count($comment_id, $rating)
    {
        return Database::query('
          Select *
          from comments_rating
          where comment_id = ? and rating = ?
    ',array($comment_id,$rating));
    }
    public static function rating_exists($user_id,$comment_id,$rating)
    {
        $rating = Database::queryOne('
        select *
        from comments_rating
        where comment_id = ? and user_id=? and rating = ? 
',array($comment_id, $user_id, $rating));
        if($rating)
        {
            return true;
        }
        return false;
    }
    public function getArticlesComments($offset, $limit, $article_url)
    {
        $comments = Database::queryAll('
                        SELECT c.content, c.post_time,c.comment_id ,u.first_name, u.last_name, u.profile_picture, u.user_id, u.profile_url
                        FROM comments as c
                        INNER JOIN articles as a on c.article_id = a.Id 
                        INNER JOIN users as u ON c.author_id = u.user_id
                        WHERE a.url = ? and  c.parent_comment IS NULL
                        order by c.post_time desc
                        LIMIT ? OFFSET ?
                        
                ', array($article_url, $limit, $offset));
        return ($this->arrayDateFormat($comments, 'post_time'));
    }
    public function commentsReplies($parent_id)
    {
        $comments = Database::queryAll('
         SELECT c.content, c.post_time,c.comment_id ,u.first_name, u.last_name, u.profile_picture, u.user_id, u.profile_url
                        FROM comments as c
                        INNER JOIN users as u ON c.author_id = u.user_id
                        WHERE c.parent_comment = ?
                        order by c.post_time asc
                        ', array($parent_id));
        return ($this->arrayDateFormat($comments, 'post_time'));
    }
    public function removeReplies($parent_id)
    {
        Database::query('
        Delete 
        from comments
        where parent_comment = ?
        ', array($parent_id));
    }
    public function removeComments($article_id)
    {
        Database::query('
        Delete 
        from comments
        where article_id = ?
        ', array($article_id));

        Database::queryAll('
        Delete r.*
        from comments_rating as r
        INNER JOIN comments as c on r.comment_id = c.comment_id
        where c.article_id = ?
        ',array($article_id));
    }

    public function load_new_reply($parent_id)
    {
        $comments = Database::queryAll('
         SELECT c.content, c.post_time,c.comment_id ,u.first_name, u.last_name, u.profile_picture, u.user_id, u.profile_url
                        FROM comments as c
                        INNER JOIN users as u ON c.author_id = u.user_id
                        WHERE c.parent_comment = ?
                        order by c.post_time desc
                        LIMIT 1 OFFSET 0

                        ', array($parent_id));
        return ($this->arrayDateFormat($comments, 'post_time'));
    }
    public function ArticleIdByUrl($url)
    {
        return Database::queryOne('
            SELECT Id
            FROM articles
            where url = ?
        ', array($url));
    }
    public function addComment($comment)
    {
        database::insert('comments',$comment);
    }
    public function deleteComment($comment_id)
    {
        Database::query('
        Delete 
        from comments
        where comment_id = ?
        ', array($comment_id));
        Database::query('
        Delete
        from comments
        where reply_to = ?

        ',$comment_id);

        Database::query('
        Delete 
        from comments_rating
        where comment_id = ?
        ', array($comment_id));
    }
    public function addArticle($article)
    {
        try
        {
            database::insert('articles',$article);
        }
        catch(PDOException $error)
        {
             throw new Exception('Zadaná URL adresa je již použita u jiného článku');
        }
    }
    public function editArticle($article, $id)
    {
        try
        {
            database::update('articles',$article,'where Id = ?',array($id));
        }
        catch(PDOException $error)
        {
            throw new Exception('Zadaná adresa URL je již použita u jiného článku');
        }
    }
    //zformátování data v asociativním poli příspěvků
    public function arrayDateFormat($array, $key)
    {
        foreach($array as $index => $value)
        {

            $array[$index][$key] = $this->singleDateFormat($array[$index][$key]);
        }
        return $array;
    }
    //funkce pro zmenšení obrázků při uploadu
    function scaleImage($source_image_path, $maxWidth, $maxHeight, $thumbnail_image_path, $source_image_height, $source_image_width, $source_image_type){

        switch ($source_image_type) {
            case IMAGETYPE_GIF:
                $source_gd_image = imagecreatefromgif($source_image_path);
                break;
            case IMAGETYPE_JPEG:
                $source_gd_image = imagecreatefromjpeg($source_image_path);
                break;
            case IMAGETYPE_PNG:
                $source_gd_image = imagecreatefrompng($source_image_path);
                break;
        }
        if ($source_image_width > $source_image_height) {
            if($source_image_width < $maxWidth)
            {
                $newwidth = $source_image_width;
            }
            else
            {
                $newwidth = $maxWidth;
            }
            $divisor = $source_image_width / $newwidth;
            $newheight = floor( $source_image_height / $divisor);
        }
        else
        {
            if($source_image_height < $maxHeight)
            {
                $newheight = $source_image_height;
            }
            else
            {
                $newheight = $maxHeight;
            }
            $divisor = $source_image_height/ $newheight;
            $newwidth = floor( $source_image_width / $divisor );
        }
        if($newheight * $newwidth >8500000)
        {
            throw new Exception("Není podporováno vyšší rozlišení než 4K");
        }
        $thumbnail_gd_image = imagecreatetruecolor($newwidth, $newheight);
        $asd=imagecolorallocate($thumbnail_gd_image, 255, 255, 255);
        imagefill($thumbnail_gd_image,0,0,$asd);
        imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $newwidth, $newheight, $source_image_width, $source_image_height);
        imagejpeg($thumbnail_gd_image, $thumbnail_image_path, 90);
        imagedestroy($source_gd_image);
        imagedestroy($thumbnail_gd_image);
    }
    public function uploadImage($target_dir, $file, $max_width, $max_height)
    {
        try {
            if($file['size']==0)
            {
                throw new Exception("Soubor nebyl nahrán");
            }


            $target_file = $target_dir . basename($file["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                throw new Exception("Nahraný soubor nemá požadovaný formát (.jpg, .jpeg, .png, .gif)");
            }
            if(!file_exists($target_file)) {
                list($source_image_width, $source_image_height, $source_image_type) = getimagesize($file["tmp_name"]);
                if($source_image_width*$source_image_height>8500000)
                {
                    throw new Exception("Není podporováno vyšší rozlišení než 4K");
                }
                if(move_uploaded_file($file["tmp_name"], $target_file))
                {


                    $this->scaleImage($target_file,$max_width, $max_height, $target_file, $source_image_height, $source_image_width, $source_image_type);
                }
            }
        } catch (Exception $error)
        {

            throw new Exception($error->getMessage());

        }
    }
    //zformátování jednoho data
    public function singleDateFormat($last_update)
    {
        $yesterday = date('d.m.Y',strtotime("-1 days"));
        $today = new DateTime();
        $last_update_date = new DateTime($last_update);
        return $this->dateToString($last_update_date, $yesterday, $today);
    }

    //Zformátuje datum poslední úpravy příspěvku na dobu, před kterou byl odeslán
    private function dateToString($last_update_date, $yesterday, $today)
    {
        if($last_update_date->format('d.m.Y')== $today->format('d.m.Y'))
        {
            $difference = date_diff($today,$last_update_date);
            $hours = $difference->d * 24 + $difference->h;
            if($hours<1)
            {
                $minutes = $difference->i;
                if($minutes<1)
                {
                    $seconds = $difference->s;
                    if($seconds == 0)
                    {
                        return "Právě teď";
                    }
                    if($seconds==1)
                    {
                        return "před 1 sekundou";
                    }
                    else
                    {
                        return "před " . $seconds . " sekundami";
                    }
                }
                else if($minutes ==1)
                {
                    return "před 1 minutou";
                }
                else
                {
                    return "před " . $minutes . " minutami";
                }
            }
            else if($hours==1)
            {
                return "před 1 hodinou";
            }
            else
            {
                return "před " . $hours . " hodinami";
            }

        }

        else if($yesterday == ($last_update_date->format('d.m.Y')))
        {
            return "včera";

        }
        else
        {
            return $last_update_date->format('j. n. Y');
        }
    }

}