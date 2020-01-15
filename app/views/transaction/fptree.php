<div class="container mt-5">
        <div class="row">
            <div class="col-6">
    <h1>FPTREE</h1>  
<ul class="list-group">
<?php foreach ($data['transactions'] as $key => $value):?>
<li class="list-group-item "><?= 'NULL'?>
<span class="badge badge-primary badge-pill"><?= $value['count']?></span>
</li> 
    <ul class="list-group">
    <?php foreach ($value['child'] as $value1):?>
    <li class="list-group-item list-group-item-primary"><?= $value1['item']?>
    <span class="badge badge-primary badge-pill"><?= $value1['count']?></span>
    </li>
        <ul class="list-group pl-2">      
        <?php if(is_array($value1['child'])):?>
        <?php foreach($value1['child'] as $value2):?>
        <li class="list-group-item list-group-item-secondary"><?= $value2['item']?>
        <span class="badge badge-primary badge-pill"><?= $value2['count']?></span>
        </li>   
                <ul class="list-group pl-3">        
                <?php if(is_array($value2['child'])):?>
                <?php foreach($value2['child'] as $value3):?>
                <li class="list-group-item list-group-item-success"><?= $value3['item']?>
                <span class="badge badge-primary badge-pill"><?= $value3['count']?></span>
                </li>      
                        <ul class="list-group pl-4">   
                        <?php if(is_array($value3['child'])):?>
                        <?php foreach($value3['child'] as $value4):?>
                        <li class="list-group-item list-group-item-danger"><?= $value4['item']?>
                        <span class="badge badge-primary badge-pill"><?= $value4['count']?></span>
                        </li>
                                <ul class="list-group pl-5">  
                                <?php if(is_array($value4['child'])):?>
                                <?php foreach($value4['child'] as $value5):?>
                                <li class="list-group-item list-group-item-warning"><?= $value5['item']?>
                                <span class="badge badge-primary badge-pill"><?= $value5['count']?></span>
                                </li>         
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </ul>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </ul>
                    <?php endforeach; ?>
                <?php endif; ?>
                </ul>
             <?php endforeach; ?>
            <?php endif; ?>
            </ul>
    <?php endforeach; ?>
    </ul>
<?php endforeach; ?>
</ul>
    
            </div>
    </div>
</div>