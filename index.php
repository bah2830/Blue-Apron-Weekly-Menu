<?php
require __DIR__ . '/vendor/autoload.php';

const ROOT_DIR = __DIR__;

$blueApron = new \BlueApron\Client();
$recipes = $blueApron->getWeeklyMenu();

$titles = [];
foreach ($recipes as $recipe) {
    $titles[] = $recipe->title;
}

$ingredients = $blueApron->getListOfIngredientsFromRecipes($titles);

?>

<html>
    <head>
        <title>Weekly Recipes</title>

        <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" type="text/css" href="/content/css/main.css?<?=time()?>" />

        <script src="/content/js/jquery-1.12.0.min.js"></script>
    </head>
    <body>
        <div class="recipe_thumbs">
            <?php foreach ($recipes as $i => $recipe): ?>
                <div class="recipe_card">
                    <div class="recipe_thumb_preview">
                        <img width="250px" src="<?=$recipe->previewImage?>" />

                        <div class="checkbox_container">
                            <input type="checkbox" name="checkbox_<?=$i?>" id="checkbox_<?=$i?>" class="css-checkbox"
                                value="<?=$recipe->title?>"
                            >
                            <label for="checkbox_<?=$i?>" class="css-label"></label>
                        </div>
                    </div>

                    <div class="cook_time"><?=$recipe->minCookTime?> - <?=$recipe->maxCookTime?></div>

                    <div class="servings"><?=$recipe->servings?></div>

                    <div class="main_title">
                        <a href="<?=$recipe->linkPath?>" target="_new">
                            <?=$recipe->previewTitle?>
                        </a>
                    </div>

                    <div class="sub_title"><?=$recipe->previewSubTitle?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="ingredient_list">&nbsp;</div>

        <script>
            $('.css-checkbox').click(function() {
                var titles = [];

                $('.css-checkbox:checkbox:checked').each(function(index) {
                    titles.push($(this).val());
                });

                $.post("ingredient_list.php", {ingredients: titles}, function(data) {
                    $('.ingredient_list').html(data);
                });
            });
        </script>
    </body>
</html>