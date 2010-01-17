
        <!-- INCLUDE block/top.tpl -->

        <h1>{user_login}</h1>

        <!-- INCLUDE block/user_menu.tpl -->

        <script type="text/javascript">var user_id = {user_id};</script>

        <h2>Edit you informations:</h2>
        <form id="user_edit" method="post" name="user_edit" action="javascript:user_edit_submit();">
            <div>
                <label>Gender:
                    <select id="user_edit_gender" name="gender" value="">
                        <option value="0"{user_edit_gender_0}>Male</option>
                        <option value="1"{user_edit_gender_1}>Female</option>
                    </select>
                </label>
            </div>
            <div>
                <label>Zip:
                    <select id="user_edit_zip" name="zip" value="">
                        <option value="1"{user_edit_zip_1}>Ain</option>
                        <option value="2"{user_edit_zip_2}>Aisne</option>
                        <option value="3"{user_edit_zip_3}>Allier</option>
                        <option value="4"{user_edit_zip_4}>Alpes-de-Haute-Provence</option>
                        <option value="5"{user_edit_zip_5}>Hautes-Alpes</option>
                        <option value="6"{user_edit_zip_6}>Alpes-Maritimes</option>
                        <option value="7"{user_edit_zip_7}>Ardèche</option>
                        <option value="8"{user_edit_zip_8}>Ardennes</option>
                        <option value="9"{user_edit_zip_9}>Ariège</option>
                        <option value="10"{user_edit_zip_10}>Aube</option>
                        <option value="11"{user_edit_zip_11}>Aude</option>
                        <option value="12"{user_edit_zip_12}>Aveyron</option>
                        <option value="13"{user_edit_zip_13}>Bouches-du-Rhône</option>
                        <option value="14"{user_edit_zip_14}>Calvados</option>
                        <option value="15"{user_edit_zip_15}>Cantal</option>
                        <option value="16"{user_edit_zip_16}>Charente</option>
                        <option value="17"{user_edit_zip_17}>Charente-Maritime</option>
                        <option value="18"{user_edit_zip_18}>Cher</option>
                        <option value="19"{user_edit_zip_19}>Corrèze</option>
                        <option value="2A"{user_edit_zip_2A}>Corse-du-Sud</option>
                        <option value="2B"{user_edit_zip_2B}>Haute-Corse</option>
                        <option value="21"{user_edit_zip_21}>Côte-d'Or</option>
                        <option value="22"{user_edit_zip_22}>Côtes-d'Armor</option>
                        <option value="23"{user_edit_zip_23}>Creuse</option>
                        <option value="24"{user_edit_zip_24}>Dordogne</option>
                        <option value="25"{user_edit_zip_25}>Doubs</option>
                        <option value="26"{user_edit_zip_26}>Drôme</option>
                        <option value="27"{user_edit_zip_27}>Eure</option>
                        <option value="28"{user_edit_zip_28}>Eure-et-Loir</option>
                        <option value="29"{user_edit_zip_29}>Finistère</option>
                        <option value="30"{user_edit_zip_30}>Gard</option>
                        <option value="31"{user_edit_zip_31}>Haute-Garonne</option>
                        <option value="32"{user_edit_zip_32}>Gers</option>
                        <option value="33"{user_edit_zip_33}>Gironde</option>
                        <option value="34"{user_edit_zip_34}>Hérault</option>
                        <option value="35"{user_edit_zip_35}>Ille-et-Vilaine</option>
                        <option value="36"{user_edit_zip_36}>Indre</option>
                        <option value="37"{user_edit_zip_37}>Indre-et-Loire</option>
                        <option value="38"{user_edit_zip_38}>Isère</option>
                        <option value="39"{user_edit_zip_39}>Jura</option>
                        <option value="40"{user_edit_zip_40}>Landes</option>
                        <option value="41"{user_edit_zip_41}>Loir-et-Cher</option>
                        <option value="42"{user_edit_zip_42}>Loire</option>
                        <option value="43"{user_edit_zip_43}>Haute-Loire</option>
                        <option value="44"{user_edit_zip_44}>Loire-Atlantique</option>
                        <option value="45"{user_edit_zip_45}>Loiret</option>
                        <option value="46"{user_edit_zip_46}>Lot</option>
                        <option value="47"{user_edit_zip_47}>Lot-et-Garonne</option>
                        <option value="48"{user_edit_zip_48}>Lozère</option>
                        <option value="49"{user_edit_zip_49}>Maine-et-Loire</option>
                        <option value="50"{user_edit_zip_50}>Manche</option>
                        <option value="51"{user_edit_zip_51}>Marne</option>
                        <option value="52"{user_edit_zip_52}>Haute-Marne</option>
                        <option value="53"{user_edit_zip_53}>Mayenne</option>
                        <option value="54"{user_edit_zip_54}>Meurthe-et-Moselle</option>
                        <option value="55"{user_edit_zip_55}>Meuse</option>
                        <option value="56"{user_edit_zip_56}>Morbihan</option>
                        <option value="57"{user_edit_zip_57}>Moselle</option>
                        <option value="58"{user_edit_zip_58}>Nièvre</option>
                        <option value="59"{user_edit_zip_59}>Nord</option>
                        <option value="60"{user_edit_zip_60}>Oise</option>
                        <option value="61"{user_edit_zip_61}>Orne</option>
                        <option value="62"{user_edit_zip_62}>Pas-de-Calais</option>
                        <option value="63"{user_edit_zip_63}>Puy-de-Dôme</option>
                        <option value="64"{user_edit_zip_64}>Pyrénées-Atlantiques</option>
                        <option value="65"{user_edit_zip_65}>Hautes-Pyrénées</option>
                        <option value="66"{user_edit_zip_66}>Pyrénées-Orientales</option>
                        <option value="67"{user_edit_zip_67}>Bas-Rhin</option>
                        <option value="68"{user_edit_zip_68}>Haut-Rhin</option>
                        <option value="69"{user_edit_zip_69}>Rhône</option>
                        <option value="70"{user_edit_zip_70}>Haute-Saône</option>
                        <option value="71"{user_edit_zip_71}>Saône-et-Loire</option>
                        <option value="72"{user_edit_zip_72}>Sarthe</option>
                        <option value="73"{user_edit_zip_73}>Savoie</option>
                        <option value="74"{user_edit_zip_74}>Haute-Savoie</option>
                        <option value="75"{user_edit_zip_75}>Paris</option>
                        <option value="76"{user_edit_zip_76}>Seine-Maritime</option>
                        <option value="77"{user_edit_zip_77}>Seine-et-Marne</option>
                        <option value="78"{user_edit_zip_78}>Yvelines</option>
                        <option value="79"{user_edit_zip_79}>Deux-Sèvres</option>
                        <option value="80"{user_edit_zip_80}>Somme</option>
                        <option value="81"{user_edit_zip_81}>Tarn</option>
                        <option value="82"{user_edit_zip_82}>Tarn-et-Garonne</option>
                        <option value="83"{user_edit_zip_83}>Var</option>
                        <option value="84"{user_edit_zip_84}>Vaucluse</option>
                        <option value="85"{user_edit_zip_85}>Vendée</option>
                        <option value="86"{user_edit_zip_86}>Vienne</option>
                        <option value="87"{user_edit_zip_87}>Haute-Vienne</option>
                        <option value="88"{user_edit_zip_88}>Vosges</option>
                        <option value="89"{user_edit_zip_89}>Yonne</option>
                        <option value="90"{user_edit_zip_90}>Territoire de Belfort</option>
                        <option value="91"{user_edit_zip_91}>Essonne</option>
                        <option value="92"{user_edit_zip_92}>Hauts-de-Seine</option>
                        <option value="93"{user_edit_zip_93}>Seine-Saint-Denis</option>
                        <option value="94"{user_edit_zip_94}>Val-de-Marne</option>
                        <option value="95"{user_edit_zip_95}>Val-d'Oise</option>
                    </select>
                </label>
            </div>
            <div><input type="submit" name="submit" value="save"></div>
        </form>
        <script type="text/javascript">user_edit_init();</script>

        <h2>Change your password:</h2>
        <form id="user_password" method="post" name="user_password" action="javascript:user_password_submit();">
            <div><label>Current password: <input id="user_password_password_0" type="password" maxlength="128" name="password_1" value="" /></label></div>
            <div><label>New password: <input id="user_password_password_1" type="password" maxlength="128" name="password_1" value="" /></label></div>
            <div><label>Confirm new password: <input id="user_password_password_2" type="password" maxlength="128" name="password_2" value="" /></label></div>
            <div><input type="submit" name="submit" value="change"></div>
        </form>
        <script type="text/javascript">user_password_init();</script>
