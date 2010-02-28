
        <script type="text/javascript">var user_id = {profile_id};</script>

        <h2>Edit you informations:</h2>
        <form id="user_edit" method="post" name="user_edit" action="{ROOT_PATH}remote/user_edit_submit" onsubmit="return user_edit_submit();" enctype="multipart/form-data">
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
                        <option value="1"{profile_edit_zip_1}>Ain</option>
                        <option value="2"{profile_edit_zip_2}>Aisne</option>
                        <option value="3"{profile_edit_zip_3}>Allier</option>
                        <option value="4"{profile_edit_zip_4}>Alpes-de-Haute-Provence</option>
                        <option value="5"{profile_edit_zip_5}>Hautes-Alpes</option>
                        <option value="6"{profile_edit_zip_6}>Alpes-Maritimes</option>
                        <option value="7"{profile_edit_zip_7}>Ardèche</option>
                        <option value="8"{profile_edit_zip_8}>Ardennes</option>
                        <option value="9"{profile_edit_zip_9}>Ariège</option>
                        <option value="10"{profile_edit_zip_10}>Aube</option>
                        <option value="11"{profile_edit_zip_11}>Aude</option>
                        <option value="12"{profile_edit_zip_12}>Aveyron</option>
                        <option value="13"{profile_edit_zip_13}>Bouches-du-Rhône</option>
                        <option value="14"{profile_edit_zip_14}>Calvados</option>
                        <option value="15"{profile_edit_zip_15}>Cantal</option>
                        <option value="16"{profile_edit_zip_16}>Charente</option>
                        <option value="17"{profile_edit_zip_17}>Charente-Maritime</option>
                        <option value="18"{profile_edit_zip_18}>Cher</option>
                        <option value="19"{profile_edit_zip_19}>Corrèze</option>
                        <option value="2A"{profile_edit_zip_2A}>Corse-du-Sud</option>
                        <option value="2B"{profile_edit_zip_2B}>Haute-Corse</option>
                        <option value="21"{profile_edit_zip_21}>Côte-d'Or</option>
                        <option value="22"{profile_edit_zip_22}>Côtes-d'Armor</option>
                        <option value="23"{profile_edit_zip_23}>Creuse</option>
                        <option value="24"{profile_edit_zip_24}>Dordogne</option>
                        <option value="25"{profile_edit_zip_25}>Doubs</option>
                        <option value="26"{profile_edit_zip_26}>Drôme</option>
                        <option value="27"{profile_edit_zip_27}>Eure</option>
                        <option value="28"{profile_edit_zip_28}>Eure-et-Loir</option>
                        <option value="29"{profile_edit_zip_29}>Finistère</option>
                        <option value="30"{profile_edit_zip_30}>Gard</option>
                        <option value="31"{profile_edit_zip_31}>Haute-Garonne</option>
                        <option value="32"{profile_edit_zip_32}>Gers</option>
                        <option value="33"{profile_edit_zip_33}>Gironde</option>
                        <option value="34"{profile_edit_zip_34}>Hérault</option>
                        <option value="35"{profile_edit_zip_35}>Ille-et-Vilaine</option>
                        <option value="36"{profile_edit_zip_36}>Indre</option>
                        <option value="37"{profile_edit_zip_37}>Indre-et-Loire</option>
                        <option value="38"{profile_edit_zip_38}>Isère</option>
                        <option value="39"{profile_edit_zip_39}>Jura</option>
                        <option value="40"{profile_edit_zip_40}>Landes</option>
                        <option value="41"{profile_edit_zip_41}>Loir-et-Cher</option>
                        <option value="42"{profile_edit_zip_42}>Loire</option>
                        <option value="43"{profile_edit_zip_43}>Haute-Loire</option>
                        <option value="44"{profile_edit_zip_44}>Loire-Atlantique</option>
                        <option value="45"{profile_edit_zip_45}>Loiret</option>
                        <option value="46"{profile_edit_zip_46}>Lot</option>
                        <option value="47"{profile_edit_zip_47}>Lot-et-Garonne</option>
                        <option value="48"{profile_edit_zip_48}>Lozère</option>
                        <option value="49"{profile_edit_zip_49}>Maine-et-Loire</option>
                        <option value="50"{profile_edit_zip_50}>Manche</option>
                        <option value="51"{profile_edit_zip_51}>Marne</option>
                        <option value="52"{profile_edit_zip_52}>Haute-Marne</option>
                        <option value="53"{profile_edit_zip_53}>Mayenne</option>
                        <option value="54"{profile_edit_zip_54}>Meurthe-et-Moselle</option>
                        <option value="55"{profile_edit_zip_55}>Meuse</option>
                        <option value="56"{profile_edit_zip_56}>Morbihan</option>
                        <option value="57"{profile_edit_zip_57}>Moselle</option>
                        <option value="58"{profile_edit_zip_58}>Nièvre</option>
                        <option value="59"{profile_edit_zip_59}>Nord</option>
                        <option value="60"{profile_edit_zip_60}>Oise</option>
                        <option value="61"{profile_edit_zip_61}>Orne</option>
                        <option value="62"{profile_edit_zip_62}>Pas-de-Calais</option>
                        <option value="63"{profile_edit_zip_63}>Puy-de-Dôme</option>
                        <option value="64"{profile_edit_zip_64}>Pyrénées-Atlantiques</option>
                        <option value="65"{profile_edit_zip_65}>Hautes-Pyrénées</option>
                        <option value="66"{profile_edit_zip_66}>Pyrénées-Orientales</option>
                        <option value="67"{profile_edit_zip_67}>Bas-Rhin</option>
                        <option value="68"{profile_edit_zip_68}>Haut-Rhin</option>
                        <option value="69"{profile_edit_zip_69}>Rhône</option>
                        <option value="70"{profile_edit_zip_70}>Haute-Saône</option>
                        <option value="71"{profile_edit_zip_71}>Saône-et-Loire</option>
                        <option value="72"{profile_edit_zip_72}>Sarthe</option>
                        <option value="73"{profile_edit_zip_73}>Savoie</option>
                        <option value="74"{profile_edit_zip_74}>Haute-Savoie</option>
                        <option value="75"{profile_edit_zip_75}>Paris</option>
                        <option value="76"{profile_edit_zip_76}>Seine-Maritime</option>
                        <option value="77"{profile_edit_zip_77}>Seine-et-Marne</option>
                        <option value="78"{profile_edit_zip_78}>Yvelines</option>
                        <option value="79"{profile_edit_zip_79}>Deux-Sèvres</option>
                        <option value="80"{profile_edit_zip_80}>Somme</option>
                        <option value="81"{profile_edit_zip_81}>Tarn</option>
                        <option value="82"{profile_edit_zip_82}>Tarn-et-Garonne</option>
                        <option value="83"{profile_edit_zip_83}>Var</option>
                        <option value="84"{profile_edit_zip_84}>Vaucluse</option>
                        <option value="85"{profile_edit_zip_85}>Vendée</option>
                        <option value="86"{profile_edit_zip_86}>Vienne</option>
                        <option value="87"{profile_edit_zip_87}>Haute-Vienne</option>
                        <option value="88"{profile_edit_zip_88}>Vosges</option>
                        <option value="89"{profile_edit_zip_89}>Yonne</option>
                        <option value="90"{profile_edit_zip_90}>Territoire de Belfort</option>
                        <option value="91"{profile_edit_zip_91}>Essonne</option>
                        <option value="92"{profile_edit_zip_92}>Hauts-de-Seine</option>
                        <option value="93"{profile_edit_zip_93}>Seine-Saint-Denis</option>
                        <option value="94"{profile_edit_zip_94}>Val-de-Marne</option>
                        <option value="95"{profile_edit_zip_95}>Val-d'Oise</option>
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
