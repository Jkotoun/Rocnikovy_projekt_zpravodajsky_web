

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
                <th scope="col">Uživatel</th>
                <th scope="col" class="hide-responsive">Email</th>
                <th scope="col" class="hide-responsive">Role</th>
                <th scope="col" class="hide-responsive">Články</th>
                <th scope="col" class="hide-responsive">Akce</th>
            </tr>
            </tr>
            </thead>
            <tbody>
            <?php foreach($users as $user):?>
                <tr class="closed table-data-toggler">
                    <td><a href="uzivatel/<?=$user['profile_url']?>"><?=$user['first_name'] . " " . $user['last_name']?> </a></td>
                    <td class="icon-down icon-td"></td>
                    <td class="cell-hide" data-label="Email"><?=$user['email']?></td>
                    <td class="cell-hide table-min-width"  data-label="Role">
                        <select class="user-role" id="<?=$user['user_id']?>"> <?php
                        foreach($roles as $role)
                        {
                           echo($role['role_id'] == $user['user_role'] ? '<option selected>'  . $role['role_name'] . '</option>' : '<option>'  .$role['role_name'] . '</option>');
                        }
                        ?>
                        </select>
                    </td>
                    <td class="cell-hide table-min-width text-center"  data-label="Články"><?=$user['articles_count']?></td>
                    <td class="cell-hide"  data-label="Akce"><a href="administrace/uzivatele/<?=$user['user_id']?>/delete"><button  class="btn delete user-delete" ><span class="icon-bin"></span></button></a></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <?php if(isset($current_page) && $max_page!=1): ?>
            <nav>
                <ul class="pagination">
                    <?php if($current_page!=1):?>

                        <li class="page-item">
                            <a class="page-link previous" href="administrace/uzivatele/<?=$current_page-1?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                        <li class="page-item"><a href="administrace/uzivatele/<?=$current_page - 1?>" class="page-link"><?=$current_page - 1?></a></li>
                    <?php endif;?>
                    <li class="page-item active-pagination"><a href="administrace/uzivatele/<?=$current_page?>" class="page-link"><?=$current_page?></a></li>
                    <?php if($current_page!=$max_page):?>
                        <li class="page-item"><a href="administrace/uzivatele/<?=$current_page+1?>" class="page-link"><?=$current_page+1?></a></li>
                        <li class="page-item">
                            <a class="page-link next" href="administrace/uzivatele/<?=$current_page+1?>" aria-label="Next">
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
</div>