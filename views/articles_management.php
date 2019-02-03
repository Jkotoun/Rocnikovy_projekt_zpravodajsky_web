

<div class="table-container">
    <?php

    if(isset($messages['success'])):
        foreach($messages['success'] as $message) :?>

            <div class="success-message message"><?=$message?><div class="message-hide"><span class="icon-cross"></span> </div> </div>
        <?php endforeach;endif;?>
    <?php if(isset($messages['errors'])):
        foreach($messages['errors'] as $message) :?>


            <div class="error-message message"><?=$message?><div class="message-hide"><span class="icon-cross"></span> </div> </div>
        <?php endforeach; endif;?>

    <div class="table-inner-container">
            <h2>Příspěvky</h2>
        <form id="search-form" method="post">
            <div class="input-group mb-3">
                <input type="search" id="search" name="search" class="form-control" placeholder="Vyhledat" value="<?=$search?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary search-button" type="submit"><span class="icon-search"></span></button>
                </div>
            </div>
        </form>
          <table class="table table-striped">
            <thead>
              <tr>

                <th scope="col">Název</th>
                <th scope="col" class="hide-responsive">Autor</th>
                <th scope="col" class="hide-responsive">Kategorie</th>
                <th scope="col" class="hide-responsive">Datum</th>
                <th scope="col" class="hide-responsive">Akce</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($articles as $article):?>
              <tr class="closed table-data-toggler">
                <td  class="nazev"><a href="/clanek/<?=$article['url']?>" ><?=$article['title']?></a> </td>
                <td class="icon-down icon-td"></td>
                <td class="cell-hide" data-label="Autor"><?=$article['first_name']. " " . $article['last_name']?></td>
                <td class="cell-hide"  data-label="Rubrika"><?=$article['category_name']?></td>
                <td class="cell-hide"  data-label="Datum"><?=$article['post_time']?></td>
                <td class="cell-hide action"  data-label="Akce"><a href="administrace/editor/<?=$article['url']?>"><button  class="btn edit" ><span class="icon-new"></span></button></a> <a href="administrace/clanky/<?=$article['url']?>/delete"><button  class="btn delete article-delete" ><span class="icon-bin"></span></button></a></td>
              </tr>
        <?php endforeach;?>
            </tbody>
          </table>
        <?php if(isset($current_page) && $max_page!=1): ?>


            <nav>
                <ul class="pagination">
                    <?php if($current_page!=1):?>

                    <li class="page-item">
                        <a class="page-link previous" href="administrace/clanky/<?=$current_page-1?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>

                    <li class="page-item"><a href="administrace/clanky/<?=$current_page - 1?>" class="page-link"><?=$current_page - 1?></a></li>
                    <?php endif;?>
                    <li class="page-item active-pagination"><a href="administrace/clanky/<?=$current_page?>" class="page-link"><?=$current_page?></a></li>
                    <?php if($current_page!=$max_page):?>
                    <li class="page-item"><a href="administrace/clanky/<?=$current_page+1?>" class="page-link"><?=$current_page+1?></a></li>
                    <li class="page-item">
                        <a class="page-link next" href="administrace/clanky/<?=$current_page+1?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                    <?php endif;?>
                </ul>
            </nav>
        <?php endif; ?>
        </div>
</div>