<?php
require __DIR__ . '/vendor/autoload.php';

const ROOT_DIR = __DIR__;

$blueApron = new \BlueApron\Client();

$recipes = $blueApron->getWeeklyMenu();
?>

<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

<style>
    body {
        font-family: 'Open Sans', sans-serif;
    }

    img:hover {
        outline: 4px solid rgba(50, 100, 200, 0.3);
    }

    .main_body {
        position: relative;
        left: 50%;
        margin-left: -700px;
        width: 1400px;
    }

    .recipe_card {
        position: relative;
        width: 380px;
        margin: 30px;
        width: auto;
        float: left;
        height: 350px;
    }

    .main_title {
        position: relative;
        top: 0;
        left: 0;
        width: 350px;
        font-size: 24px;
        font-weight: bold;
        overflow-wrap: break-word;
    }

    .sub_title {
        position: relative;
        top: 0;
        left: 0;
        width: 350px;
        color: #aaa;
        overflow-wrap: break-word;
    }
</style>

<div class="main_body">
    <?php foreach ($recipes as $recipe): ?>
        <div class="recipe_card">
            <a href="<?=$recipe->linkPath?>" target="_new">
                <img width="370px" src="<?=$recipe->previewImage?>" />
            </a>

            <div class="main_title"><?=$recipe->previewTitle?></div>

            <div class="sub_title"><?=$recipe->previewSubTitle?></div>
        </div>
    <?php endforeach; ?>
</div>