<h1><?=$title?></h1>

<?php

if(isset($messages['success'])):
    foreach($messages['success'] as $message) :?>

        <div class="success-message message"><?=$message?><div class="message-hide"><span class="icon-cross"></span> </div> </div>
    <?php endforeach;endif;?>
<?php if(isset($messages['errors'])):
    foreach($messages['errors'] as $message) :?>


        <div class="error-message message"><?=$message?><div class="message-hide"><span class="icon-cross"></span> </div> </div>
    <?php endforeach; endif;?>
<form method="post" enctype="multipart/form-data" class="new-article">

    <div class="form-group">
        <label for="title">Název</label>
        <input type="text" class="form-control" name="title" id="title" value="<?=$article['title']?>">
        <div class="form-error-text"></div>
    </div>
    <div class="form-group">
        <label for="url">Url</label>
        <input type="text" class="form-control" name="url" id="url" value="<?=$article['url']?>">
        <div class="form-error-text"></div>
    </div>
    <div class="form-group">
        <label for="keywords">Klíčová slova (oddělená čárkou)</label>
        <input type="text" class="form-control" name="keywords" id="keywords" value="<?=$article['keywords']?>">
        <div class="form-error-text"></div>
    </div>
    <div class="form-group">
        <label for="categories">Kategorie</label>
        <select class="form-control" name="categories" id="categories">

            <?php if(isset($article['category_name']))
            {
                foreach($categories as $category)
                {
                echo($article['category_name'][0] == $category['category_name'] ? '<option selected>'  . $category['category_name'] . '</option>' : '<option>'  . $category['category_name'] . '</option>');
                    }}
                    else
            {
                {foreach($categories as $category)

                    echo('<option>'  . $category['category_name'] . '</option>');
                }
            }?>
        </select>
    </div>
    <div class="form-group">
        <label class="upload-label">Náhledový obrázek</label>
        <div class="image-upload">
            <input type="file" id="preview-image" name="preview-image" class="inputfile" value="<?=$article['img_url']?>"/>
            <label for="preview-image"><span class="upload-text"><?=$article['img_url']?></span><span class="choose"><i class="icon-upload"></i> Vybrat soubor</span></label>
            <div class="form-error-text"></div>
        </div>
    </div>
<div class="form-group">
        <label for="description">Úvod</label>
        <textarea  class="form-control" name="description" id="description"><?=$_article['description']?></textarea>
        <div class="form-error-text"></div>
</div>

    <div class="form-group">
        <label>Obsah</label>
        <div class="toolbar">
            <button type="button" class="tool-items italic editor-italic"></button>
            <button type="button" class="tool-items bold editor-bold"></button>
            <button type="button" class="tool-items link editor-link"></button>
            <button type="button" class="tool-items undo editor-undo"></button>
            <button type="button" class="tool-items redo editor-redo"></button>
            <button type="button" class="tool-items color editor-palette"></button>
            <button type="button" class="tool-items unordered_list editor-list"></button>
            <div class="dropdown">
                <button type="button" class="tool-items editor-text-height" data-toggle="dropdown">

                </button>
                <div class="dropdown-menu">
                    <button type="button" class="dropdown-item heading1"><h1>Nadpis 1</h1></button>
                    <button type="button" class="dropdown-item heading2"><h2>Nadpis 2</h2></button>
                    <button type="button" class="dropdown-item heading3"><h3>Nadpis 3</h3></button>
                    <button type="button" class="dropdown-item heading4"><h4>Nadpis 4</h4></button>
                    <button type="button" class="dropdown-item heading5"><h5>Nadpis 5</h5></button>
                    <button type="button" class="dropdown-item heading6"><h6>Nadpis 6</h6></button>
                </div>
            </div>
            <button type="button" class="tool-items remove_format editor-clear-formatting"></button>
        </div>
        <div contenteditable="true" id="content-editor" class="editor"><?=$_article['content']?><p><br></p></div>
        <textarea  class="form-control" name="content" id="content"></textarea>
        <div class="form-error-text"></div>
    </div>
    <button type="submit" class="btn btn-primary">Odeslat</button>
</form>