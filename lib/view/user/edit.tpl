
        <script type="text/javascript">var user_id = {profile_id};</script>

        <h2>Edit you informations:</h2>
        <form id="user_edit" method="post" name="user_edit" action="{ROOT_PATH}remote/user/edit/submit" onsubmit="return user_edit_submit();" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{profile_id}" />
            <input type="hidden" name="login" value="{profile_login}" />
            <div>
                <label>Gender:
                    <select id="user_edit_gender" name="gender" value="">
                        <option value="0"{profile_edit_gender_0}>Male</option>
                        <option value="1"{profile_edit_gender_1}>Female</option>
                    </select>
                </label>
            </div>
            <div>
                <label>Zip:
                    <select id="user_edit_zip" name="zip" value="">
                        <option value="1"{profile_edit_zip_1}>Alsace</option>
                        <option value="2"{profile_edit_zip_2}>Aquitaine</option>
                        <option value="3"{profile_edit_zip_3}>Auvergne</option>
                        <option value="4"{profile_edit_zip_4}>Basse-Normandie</option>
                        <option value="5"{profile_edit_zip_5}>Bourgogne</option>
                        <option value="6"{profile_edit_zip_6}>Bretagne</option>
                        <option value="7"{profile_edit_zip_7}>Centre</option>
                        <option value="8"{profile_edit_zip_8}>Champagne-Ardenne</option>
                        <option value="9"{profile_edit_zip_9}>Corse</option>
                        <option value="10"{profile_edit_zip_10}>Franche-Comté</option>
                        <option value="11"{profile_edit_zip_11}>Haute-Normandie</option>
                        <option value="12"{profile_edit_zip_12}>Île-de-France</option>
                        <option value="13"{profile_edit_zip_13}>Languedoc-Roussillon</option>
                        <option value="14"{profile_edit_zip_14}>Limousin</option>
                        <option value="16"{profile_edit_zip_16}>Lorraine</option>
                        <option value="17"{profile_edit_zip_17}>Midi-Pyrénées</option>
                        <option value="18"{profile_edit_zip_18}>Nord-Pas-de-Calais</option>
                        <option value="19"{profile_edit_zip_19}>Pays de la Loire</option>
                        <option value="20"{profile_edit_zip_20}>Picardie</option>
                        <option value="21"{profile_edit_zip_21}>Poitou-Charentes</option>
                        <option value="22"{profile_edit_zip_22}>Provence-Alpes-Côte d'Azur</option>
                        <option value="23"{profile_edit_zip_23}>Rhône-Alpes</option>
                    </select>
                </label>
            </div>
            <div>
                <label>Avatar: <input type="file" name="avatar" /></label>
                <p>
                    You can upload a JPG, GIF or PNG file<br />
                    Max size : 450 KB<br />
                    Max width : 1680 px<br />
                    Max height : 1680 px
                </p>
            </div>
            <div><input type="submit" name="submit" value="save"></div>
        </form>
        <script type="text/javascript">user_edit_init();</script>

        <h2>Change your password:</h2>
        <form id="user_password" method="post" name="user_password" action="{ROOT_PATH}remote/user_password_submit" onsubmit="return user_password_submit();">
            <input type="hidden" name="id" value="{profile_id}" />
            <input type="hidden" name="login" value="{profile_login}" />
            <div><label>Current password: <input id="user_password_password_0" type="password" maxlength="128" name="password_1" value="" /></label></div>
            <div><label>New password: <input id="user_password_password_1" type="password" maxlength="128" name="password_1" value="" /></label></div>
            <div><label>Confirm new password: <input id="user_password_password_2" type="password" maxlength="128" name="password_2" value="" /></label></div>
            <div><input type="submit" name="submit" value="change"></div>
        </form>
        <script type="text/javascript">user_password_init();</script>
