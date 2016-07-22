<?php
require __DIR__ . '/../vendor/autoload.php';

const ROOT_DIR = __DIR__;

$titles = [];
if (isset($_POST['ingredients'])) {
    $titles = $_POST['ingredients'];
}

$blueApron = new \BlueApron\Client();
$ingredients = $blueApron->getListOfIngredientsFromRecipes($titles);
?>

<style>
    .ingredient_list_table {
        width: 100%;
        font-size: 12px;
        border-spacing: 0;
    }

    .ingredient_list_table  tr  td {
        border-bottom: 1px solid #ccc;
        padding-top: 5px;
    }

    .ingredient_delete {
        color: #aa0000;
        font-weight: bold;
    }
</style>

<?php if (count($ingredients)): ?>
    <div class="ingredient_list_header">Shopping List</div>

    <div id="ingredient_list_content">
        <?php foreach ($titles as $title): ?>
            <?=$title?><br>
        <?php endforeach; ?>

        <h3>Ingredients</h3>
        <table class='ingredient_list_table'>
            <?php $count = 0; ?>
            <?php foreach ($ingredients as $i => $ingredient): ?>
                <tr id='ingredient_<?=$count?>'>
                    <td width='300px' valign='bottom'><?=$ingredient->name?></td>
                    <td valign='bottom' align='right'><?=$ingredient->quantity?></td>
                    <td width="20px" valign='bottom' align='right'><a href='#' class='ingredient_delete' id='<?=$count?>'>X</a></td>
                </tr>
                <?php $count++; ?>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>

<script>
    $('.ingredient_delete').click(function() {
        var id = $(this).attr('id');
        var rowId = 'ingredient_' + id;

        $('#' + rowId).remove();
    });
</script>
