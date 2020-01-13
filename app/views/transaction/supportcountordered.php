<div class="container mt-5">
        <div class="row">
            <div class="col-6">
    <h1>Support Count Ordered</h1>
    <div class="list-group">
    <?php foreach($data['transactions'] as $brands => $supportCountBrandNotOrdered) : ?>
        <a href="#" class="list-group-item list-group-item-action">
             <div class="d-flex w-100 justify-content-between">
                 <h5 class="mb-1">
                     <?= $brands; ?>
                 </h5>
                 <small>brand</small>
             </div>
    <p class="mb-1">Jumlah item terjual <?= $supportCountBrandNotOrdered; ?></p>
    <small>Selama: (Rentang Waktu)</small>
        </a>
                <?php endforeach; ?>
             </div>
    
        </div>
    </div>
</div>