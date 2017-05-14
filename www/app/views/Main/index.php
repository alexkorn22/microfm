<?
/**
 * @var $posts
 */
?>
<?foreach ($posts as $post):?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><?=$post['title']?></h3>
        </div>
        <div class="panel-body">
            <?=$post['text']?>
        </div>
    </div>
<?endforeach;?>