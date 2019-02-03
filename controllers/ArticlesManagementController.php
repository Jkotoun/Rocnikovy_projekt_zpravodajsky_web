<?php

class ArticlesManagementController extends Controller
{
    public function process($params)
    {
        if (!UserRoles::logged_user_can('edit-articles')) {
            $this->redirect('chyba');
        }
        $contentManager = new ContentManager();
    $search='';
        $this->head = array(
            'title' => 'Správa článků',
            'keywords' => 'články, administrace',
            'description' => 'Správá článků v administraci',
            'scripts' => array('admin_script.js')
        );
        if ($_POST) {
            $search = $_POST['search'];
            $articles = $contentManager->searchArticles($search);
        }
        else {
            if (isset($params[0]) && isset($params[1]) && $params[1] == 'delete') {
                try {
                    if (!UserRoles::logged_user_can('edit-articles')) {
                        throw new Exception("Nedostatečná oprávnění");
                    }
                    $article_id = ($contentManager->ArticleIdByUrl($params[0]))['Id'];
                    $contentManager->removeComments($article_id);
                    $contentManager->removeArticle($params[0]);

                    $this->addSuccess("Článek odstraněn");
                    $this->redirect('administrace/clanky');

                } catch (Exception $error) {
                    $this->addError($error->getMessage());
                }

            }
            else if (isset($params[0]) && is_numeric($params[0])) {
                $current_page = $params[0];
                $page_count = 10;
                $max_page = ceil($contentManager->ArticlesCount() / $page_count);
                if ($current_page > $max_page) {
                    $this->redirect('administrace/clanky/' . $max_page);
                }
                if ($current_page < 1) {
                    $this->redirect('administrace/clanky/1');
                }
                $articles = $contentManager->ArticlesInfo($page_count, ($current_page * $page_count) - $page_count);
                $this->data['current_page'] = $current_page;
                $this->data['max_page'] = $max_page;


            } else {
                $this->data['current_page'] = 1;
                $this->data['max_page'] = ceil($contentManager->ArticlesCount() / 10);
                $articles = $contentManager->ArticlesInfo(10, 0);
            }
        }

        foreach($articles as $index => $value)
        {
            $date = new DateTime($articles[$index]['post_time']);
            $articles[$index]['post_time'] = $date->format('j. n. Y');
        }
        $this->data['articles'] = $articles;
        $this->data['search']=$search;
        $this->head['active_menu_li'] ='articles-management';
        $this->view = 'articles_management';
        $this->data['messages'] = $this->getMessages();
    }
}