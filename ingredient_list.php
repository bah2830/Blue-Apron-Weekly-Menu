<?php
require __DIR__ . '/vendor/autoload.php';

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
</style>

<?php if (count($ingredients)): ?>
    <div class="ingredient_list_header">Shopping List</div>

    <div id="ingredient_list_content">
        <table class='ingredient_list_table'>
            <?php foreach ($ingredients as $ingredient): ?>
                <tr>
                    <td width='300px' valign='bottom'><?=$ingredient->name?></td>
                    <td valign='bottom' align='right'><?=$ingredient->quantity?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>
