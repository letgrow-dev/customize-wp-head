<div id="wpbody-content">
    <div class="wrap">
        <?php if ($saved) { ?>
            <script>
                function dismissNotice() {
                    document.getElementById('message').style.display = 'none';
                }
            </script>
            <div id="message" class="notice is-dismissible updated">
                <p><?= __("Data has been saved.", "letgrow-head-and-body") ?></p>
                <button type="button" class="notice-dismiss" onclick="dismissNotice()">
                    <span class="screen-reader-text"><?= __("Hide message", "letgrow-head-and-body") ?></span>
                </button>
            </div>
        <?php } ?>
        <h1><?= __("Custom integrations", 'letgrow-head-and-body') ?></h1>
        <form name="form" action="options-general.php?page=head_and_body" method="post">
            <input type="hidden" id="_wpnonce" name="_wpnonce" value="d1c0121beb"><input type="hidden"
                   name="_wp_http_referer" value="/wp-admin/options-general.php?page=head_and_body">
            <p>
                <?= __("Allows you to set your own content in the <code>&lt;head&gt;</code> tag and before the <code>&lt;body&gt;</code> tag. This is useful for setting up Google Analytics code or verifying GSC (Google Search Console) and other integrations.", 'letgrow-head-and-body') ?>
            </p>
            <p>
                <?= __("Custom integrations allow you to insert code that integrates the site with any external service.", 'letgrow-head-and-body') ?>
            </p>
            <table class="form-table permalink-structure" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row">
                            <?= __("Content of the <code>&lt;head&gt;</code> tag", "letgrow-head-and-body") ?>
                        </th>
                        <td>
                            <fieldset>
                                <p><label
                                           for="head_tag_content"><?= __("Please be aware that if you input incorrect data, your browser will automatically push it to the <code>&lt;body&gt;</code> tag. ", "letgrow-head-and-body") ?></label>
                                </p>
                                <legend class="screen-reader-text">
                                    <span><?= __("Content of the <code>&lt;head&gt;</code> tag", "letgrow-head-and-body") ?></span>
                                </legend>
                                <textarea
                                          name="head_tag_content" rows="15" cols="50"
                                          class="large-text code"><?= $head_tag_content ?></textarea>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <?= __("Content of the <code>&lt;body&gt;</code> tag", "letgrow-head-and-body") ?>
                        </th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?= __("Content of the <code>&lt;body&gt;</code> tag", "letgrow-head-and-body") ?></span>
                                </legend>
                                <textarea name="body_tag_content" rows="10" cols="50"
                                          class="large-text code"><?= $body_tag_content ?></textarea>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __("Cleanup on deactivate", "letgrow-head-and-body") ?></th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?= __("Cleanup on deactivate", "letgrow-head-and-body") ?></span>
                                </legend>
                                <label for="users_can_regispan">
                                    <input name="clear_on_deactivate" type="checkbox"
                                           value="<?= $clear_on_deactivate ?>" <?= $clear_on_deactivate === true ? "checked=\"checked\"" : "" ?>>
                                    <?= __("Clear all plugin data when plugin is deactivated", "letgrow-head-and-body") ?></label>
                            </fieldset>
                        </td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title"><?= __("Troubleshooting", "letgrow-head-and-body") ?></h2>
            <p><?= __("If you don't see provided data in website content make sure that your theme supports <a href=\"https://developer.wordpress.org/themes/advanced-topics/plugin-api-hooks/\">Plugin API Hooks</a>", 'letgrow-head-and-body') ?>
            </p>

            <p class="submit">
                <input
                       type="submit"
                       name="submit"
                       id="submit"
                       class="button button-primary"
                       value="<?= __("Save changes", "letgrow-head-and-body") ?>">
            </p>
        </form>
    </div>

    <div class="clear"></div>
</div>