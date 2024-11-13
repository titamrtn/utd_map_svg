<?php
/**
 * @var \UtdMapSvg\Database\Entity\Map[] $maps
 */
?>
<div class="wrap">
    <div id="listTitle">
        <h1>
            Map SVG
            <a href="admin.php?page=utd_map_svg&render=add" type="submit" class="button">Ajouter une map</a>
        </h1>
    </div>

    <table class="wp-list-table widefat fixed striped pages">
        <thead>
        <tr>
            <th>Titre</th>
            <th>Shortcode</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
		<?php foreach ( $maps as $map ) : ?>
            <tr>
                <td><?= $map->name ?></td>
                <td>[utd_map_svg id="<?= $map->slug ?>"]</td>
                <td>
                    <a href="admin.php?page=utd_map_svg&render=edit&map_id=<?= $map->id ?>" class="button button-primary">Modifier</a>
                    <a href="admin.php?page=utd_map_svg_delete&id=<?= $map->id ?>" class="button">Supprimer</a>
                </td>
            </tr>
		<?php endforeach; ?>
        </tbody>
    </table>
</div>