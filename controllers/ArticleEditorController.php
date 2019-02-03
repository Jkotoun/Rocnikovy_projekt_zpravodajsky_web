<?php

class ArticleEditorController extends Controller
{
    public function process($params)
    {
        if(!(UserRoles::logged_user_can('add-articles') && UserRoles::logged_user_can('edit-articles')))
        {
            $this->redirect('chyba');
        }
        $contentManager = new ContentManager();
        if(empty($params[0]))
        {
            $article = array(
                'title' => '',
                'url' => '',
                'category_id' => '',
                'keywords' => '',
                'description' => '',
                'author_id' => '',
                'content' => '',
                'img_url' => ''
            );
            if($_POST) {

                $content = str_replace("<p><br></p>","",$_POST['content']);
                $category_id = $contentManager->CategoryId($_POST['categories']);
                $article = array(
                    'title' => $_POST['title'],
                    'url' => $_POST['url'],
                    'category_id' => $category_id['category_id'],
                    'img_url' => $_FILES['preview-image']['name'],
                    'keywords' => $_POST['keywords'],
                    'description' => $_POST['description'],
                    'author_id' => (UserManager::getLoggedUser())['user_id'],
                    'content' =>$content
                );
                    try
                    {
                        if(preg_match('/[^A-Za-z0-9-]/',$article['url']))
                        {
                            throw new Exception($article['url']);
                        }
                        if(!UserRoles::logged_user_can('add-articles'))
                        {
                            throw new Exception("Nedostatečná oprávnění");
                        }
                        $contentManager->uploadImage("public/uploads/images/", $_FILES["preview-image"],1000,450);
                        $contentManager->addArticle($article);
                        $this->addSuccess('Článek přidán');
                        $this->redirect('administrace/clanky');
                    }
                    catch(Exception $error)
                    {
                        $this->addError($error->getMessage());
                        $article['img_url'] = '';
                    }

            }
            $this->data['article'] = $article;
            $this->data['title'] = "Nový článek";
            $this->head['active_menu_li'] ="new-article";
        }

        else
        {
            $article = $contentManager->getArticle($params[0]);
            if(!$article)
            {
               $this->redirect('chyba');
            }
            else
            {
                $this->data['article'] = $article;

                $this->data['article']['category_name'] = $contentManager->CategoryNameById($article['category_id']);
            }
            if($_POST)
            {
                $category_id = $contentManager->CategoryId($_POST['categories']);
                $content= str_replace("<p><br></p>","",$_POST['content']);
                $article_edit = array(
                    'title' => $_POST['title'],
                    'url' => $_POST['url'],
                    'category_id' => $category_id['category_id'],
                    'keywords' => $_POST['keywords'],
                    'description' => $_POST['description'],
                    'author_id' => (UserManager::getLoggedUser())['user_id'],
                    'content' =>  $content

                );

                try {
                    if(!UserRoles::logged_user_can('edit-articles'))
                    {
                        throw new Exception("Nedostatečná oprávnění");
                    }
                    if(!empty($_FILES['preview-image']['name']))
                    {

                        $article_edit['img_url'] = $_FILES['preview-image']['name'];
                        $contentManager->uploadImage("public/uploads/images/", $_FILES["preview-image"],1000,450);
                    }
                    $contentManager->editArticle($article_edit, $article['Id']);
                    $this->addSuccess('Článek upraven');
                    $this->redirect('administrace/clanky');
                }
                catch(Exception $error)
                {
                    $this->addError($error->getMessage());
                }
            }
            $this->data['title'] = "Upravit článek";
            $this->head['active_menu_li'] ="articles-management";

        }

        $this->head['title'] = "Editor";

        $this->view = 'editor';
        $this->head['description'] = "Editor článků";
        $this->head['keywords'] = "editor";
        $this->head['scripts'] = array( 'Forms.js', 'file-upload.js', 'admin_script.js');
        $this->data['categories']=$contentManager->AllCategories();
        $this->data['messages'] = $this->getMessages();



    }
}