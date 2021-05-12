<?php require_once 'display-header.php' ?>

<?= display_header('Liste des catégories', 'clipboard-list') ?>

<section class="py-5">
    <div class="container">
        <?= display_session_alert(); ?>
        <?= display_session_alert('warning'); ?>
        <?= display_session_alert('info'); ?>

        <div class="card">
            <div class="card-header  bg-dark text-light">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="fs-2 mb-2 b-title text-start">Liste des catégories</h1>
                    </div>
                    <div class="col-md-4">
                        <form action="<?= $_SERVER['PHP_SELF'] ?>">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control rounded-0" placeholder="Rechercher..." aria-label="Rechercher..." aria-describedby="basic-addon1" name="q" value="<?= get_get_data($_GET, 'q') ?>">
                                <button class="btn btn-outline-success input-group-text rounded-0" id="basic-addon1"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body border-top border-orange">
                <table class="table table-striped table-hover">
                    <thead class="text-uppercase fw-bold">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Date Création </th>
                            <th scope="col">Auteur</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td scope="row"><?= $category->id ?></td scope="row">
                            <td class="fw-bold"><?= $category->title ?></td>
                            <td><?= time_format($category->created_at) ?></td>
                            <td><?= $category->author ?></td>
                            <td>
                                <a href="edit_category.php?id=<?= $category->id ?>" class="btn btn-sm btn-primary rounded-0"><i class="fas fa-edit"></i></a>
                                <a href="delete_category.php?id=<?= $category->id ?>" onclick="return(confirm('Confirmer la suppression de cet élément'))" class="btn btn-sm btn-danger rounded-0"><i class="fas fa-trash-alt"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-dark rounded-0" data-bs-toggle="modal" data-bs-target="#<?= $category->title.$category->id ?>"><i class="fas fa-info-circle"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <nav class="blog-pagination mb-2"><!-- Pagination -->
                <ul class="cc-pagination">
                <?php if($totalPages > 1): ?>
                    <?php if($page > 1 && $totalPages > 1): ?>
                    <li class="cc-page-item">
                        <a href="?<?= http_build_query(array_merge($_GET, ['p' =>$page - 1]))?>" class="page-path <?= ($page > 1 && $totalPages > 0) ? '' : 'disabled'?>">
                            <span><i class="fas fa-angle-double-left"></i></span>
                        </a>
                    </li>
                    <?php endif;?>

                    <?php if($totalPages >= 1 && $page <= $totalPages): ?>
                        <li class="cc-page-item"><a href="?<?= http_build_query(array_merge($_GET, ['p' => 1]))?>" class="page-path <?= (!empty($_GET['p']) && $_GET['p'] == 1) ? ' active' : '' ?> ?>">1</a></li>
                        <?php
                            $i = max(2, $page - 2);
                            if ($i > 2) echo '<li class="p-1">...</li>';
                        ?>
                        <?php for (; $i < min($page + 2, $totalPages); $i++):
                            ?>
                                <li class="cc-page-item"><a href="?<?= http_build_query(array_merge($_GET, ['p' =>$i]))?>" class="page-path<?= (!empty($_GET['p']) && $_GET['p'] == $i) ? ' active' : '' ?>"><?= $i ?></a></li>
                        <?php endfor; ?>
                        <?php
                            if ($i != $totalPages) echo '<li class="p-1">...</li>';
                        ?>
                        <li class="cc-page-item"><a href="?<?= http_build_query(array_merge($_GET, ['p' =>$totalPages]))?>" class="page-path <?= (!empty($_GET['p']) && $_GET['p'] == $totalPages) ? ' active' : '' ?> ?>"><?= $totalPages ?></a></li>
                    <?php endif; ?>

                    <?php if($totalPages > 1 && $page < $totalPages): ?>
                    <li class="cc-page-item">
                        <a href="?<?= http_build_query(array_merge($_GET, ['p' =>$page + 1]))?>" class="page-path  <?= ($totalPages > 1 && $page < $totalPages) ? '' : 'disabled'?>">
                            <span><i class="fas fa-angle-double-right"></i></span>
                        </a>
                    </li>
                    <?php endif; ?>
                <?php endif;?>
                </ul>
            </nav><!-- End pagination -->
        </div>

        <div class="category-info">
            <!-- Modal -->
            <?php foreach($categories as $category): ?>
            <div class="modal fade" id="<?= $category->title.$category->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><?= $category->title ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Catégorie N° <?= $category->id ?> crée le <?= time_format($category->created_at) ?> par <?= $category->author ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>