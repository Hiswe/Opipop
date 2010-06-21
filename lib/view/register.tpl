
        <!-- SECTION login -->
        <form id="register" class="modal" method="post" name="register" action="javascript:Register.submit();">
            <fieldset>
            <label>
                <em>Login :</em>
                <input id="register_login" type="text" maxlength="32" name="login" value="" />
            </label>
            <label>
                <em>Password:</em>
                <input id="register_password_1" type="password" maxlength="128" name="password_1" value="" />
            </label>
            <label>
                <em>Confirm password:</em>
                <input id="register_password_2" type="password" maxlength="128" name="password_2" value="" />
            </label>
            <label>
                <em>Email:</em>
                <input id="register_email" type="text" maxlength="320" name="email" value="" />
            </label>
            </fieldset>
            <fieldset>
                <label>
                    <em>Gender:</em>
                    <select id="register_gender" name="gender" value="">
                        <option value="" disabled="disabled">-- SELECT --</option>
                        <option value="0">Male</option>
                        <option value="1">Female</option>
                    </select>
                </label>
                <label>
                    <em>Zip:</em>
                    <select id="register_zip" name="zip" value="">
                        <option value="0" disabled="disabled">-- SELECT --</option>
                        <option value="1">Alsace</option>
                        <option value="2">Aquitaine</option>
                        <option value="3">Auvergne</option>
                        <option value="4">Basse-Normandie</option>
                        <option value="5">Bourgogne</option>
                        <option value="6">Bretagne</option>
                        <option value="7">Centre</option>
                        <option value="8">Champagne-Ardenne</option>
                        <option value="9">Corse</option>
                        <option value="10">Franche-Comté</option>
                        <option value="11">Haute-Normandie</option>
                        <option value="12">Île-de-France</option>
                        <option value="13">Languedoc-Roussillon</option>
                        <option value="14">Limousin</option>
                        <option value="16">Lorraine</option>
                        <option value="17">Midi-Pyrénées</option>
                        <option value="18">Nord-Pas-de-Calais</option>
                        <option value="19">Pays de la Loire</option>
                        <option value="20">Picardie</option>
                        <option value="21">Poitou-Charentes</option>
                        <option value="22">Provence-Alpes-Côte d'Azur</option>
                        <option value="23">Rhône-Alpes</option>
                    </select>
                </label>
                </fieldset>
                <fieldset><input type="submit" name="submit" value="register"></fieldset>
        </form>
        <!-- END login -->

