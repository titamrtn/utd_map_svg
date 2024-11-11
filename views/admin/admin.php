<div class="wrap">
	<div id="listTitle">
		<h1>
			Map SVG
		</h1>
	</div>

	<form action="admin-post.php" method="POST">

        <input type="hidden" name="action" value="utd_map_svg_save">
        <table>
            <thead>
            <tr>
                <th>Pays</th>
                <th>URL</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (\UtdMapSvg\Data\Country::LIST as $code => $countryName) : ?>
                <tr>
                    <td><?= $countryName ?></td>
                    <td>
                        <input type="text" name="url[<?= $code ?>]" value="<?= $urls[$code] ?? ''?>">
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="button button-primary">
            Enregistrer
        </button>
	</form>
</div>

