<style>
    h3 {
        color: #3858e9;
        margin: 10px 0;
    }
    .form_flex {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 20px;
    }

    .form_flex .form_part {
        flex: 1;
        border: 1px solid #ccc;
        padding: 0 10px;
        background: white;
        border-radius: 10px;
    }

    table {
        width: 100%;
    }
</style>
<div class="wrap">
    <div style="margin-bottom: 10px">
        <h1>
            Map SVG
        </h1>
    </div>

    <form action="admin-post.php" method="POST" >

        <input type="hidden" name="action" value="utd_map_svg_save">
        <input type="hidden" name="id" value="<?= $map->id ?? ''?>">
        <div class="form_flex">
            <div class="form_part">
                <h3>UI Map</h3>
                <table>
                    <tr>
                        <td>
                            <label for="name">Nom</label>
                        </td>
                        <td>
                            <input type="text" name="name" id="name" value="<?= $map->name ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="slug">Slug shortcode</label>
                        </td>
                        <td>
                            <input type="text" name="slug" id="slug" value="<?= $map->slug ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="fill_color">Couleur de la map</label>
                        </td>
                        <td>
                            <input type="text" class="color_pick" name="fill_color" id="fill_color" value="<?= $map->fill_color ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="hover_color">Couleur au survol</label>
                        </td>
                        <td>
                            <input type="text" class="color_pick" name="hover_color" id="hover_color" value="<?= $map->hover_color ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="highlight_color">Couleur des pays avec url</label>
                        </td>
                        <td>
                            <input type="text" class="color_pick" name="highlight_color" id="highlight_color" value="<?= $map->highlight_color ?>">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form_part">
                <h3>Pays à afficher</h3>
                <table>
                    <thead>
                    <tr>
                        <td>Pays</td>
                        <td>URL</td>
                    </tr>
                    </thead>
                    <tbody id="countries_form">
                    <?php if(empty($map->countries)): ?>
                    <tr>
                        <td>
                            <select name="countries[]" id="countries" required>
                                <option value="">Choisir un pays</option>
                                <?php foreach ( $countries as $countryCode => $countryName ) : ?>
                                    <option value="<?= $countryCode ?>"><?= $countryName ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="url[]" id="url" required>
                        </td>
                        <td></td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ( $map->countries as $key => $country ) : ?>
                            <tr>
                                <td>
                                    <select name="countries[]" id="countries" required>
                                        <option value="">Choisir un pays</option>
                                        <?php foreach ( $countries as $countryCode => $countryName ) : ?>
                                            <option value="<?= $countryCode ?>" <?= $countryCode === $country['country'] ? 'selected' : '' ?>><?= $countryName ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="url[]" id="url" value="<?= $country['url'] ?>" required>
                                </td>
                                <td>
                                    <button type="button" class="button deleteCountry">Supprimer</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
                <button type="button" class="button" id="addCountry" style="margin: 10px 0">Ajouter</button>
            </div>
        </div>
        <div>
            <button type="submit" class="button button-primary">
                Enregistrer
            </button>
        </div>
    </form>
</div>

<script>
    jQuery(document).ready(function($){
        const slugField = $('#slug');

        $('#name').on('blur', function () {
            if (slugField.val() === '') {
                const slug = $(this).val()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9 ]/g, '')
                    .replace(/\s+/g, '-')

                slugField.val(slug);
            }
        });

        $('.color_pick').wpColorPicker();

        $('#addCountry').on('click', function () {
            const newRow = $('#countries_form tr').first().clone();
            newRow.find('select').val('');
            newRow.find('input').val('');
            newRow.find('td').last().html('<button type="button" class="button deleteCountry">Supprimer</button>');

            $('#countries_form').append(newRow);
        });

        $('#countries_form').on('click', '.deleteCountry', function () {
            $(this).closest('tr').remove();
        });
    });
</script>
