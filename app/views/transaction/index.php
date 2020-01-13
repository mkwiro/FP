    <div class="container mt-5">
        <div class="row">
            <div class="col-6">
        <h1>Transaksi Dagadu</h1>
        <ul class="list-group">
        <?php  
        foreach($data['transactions'] as $keytr => $transactions):?>
            <li class="list-group-item list-group-item-success">
            <?= $keytr; ?>
            </li>
            <?php   foreach($transactions as $transaction):?>
                <li class="list-group-item">
                <?= $transaction; ?>
                </li>
                <?php endforeach; ?>
            <?php endforeach; ?>
            </ul>
            </div>
        </div>
    </div>
   