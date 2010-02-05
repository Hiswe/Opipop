
		<!-- SECTION login -->
        <h2>Login an existing user</h2>
        <form id="login" method="post" name="login" action="javascript:login_submit();">
            <div><label>Login: <input id="login_login" type="text" maxlength="32" name="login" value="" /></label></div>
            <div><label>Password: <input id="login_password" type="password" maxlength="128" name="password" value="" /></label></div>
            <div><input type="submit" name="submit" value="login"></div>
        </form>
        <script type="text/javascript">login_init();</script>

        <h2>Register a new user</h2>
        <form id="register" method="post" name="register" action="javascript:register_submit();">
            <div><label>Login: <input id="register_login" type="text" maxlength="32" name="login" value="" /></label></div>
            <div>
                <label>Gender:
                    <select id="register_gender" name="gender" value="">
                        <option value="" disabled="disabled">-- SELECT --</option>
                        <option value="0">Male</option>
                        <option value="1">Female</option>
                    </select>
                </label>
            </div>
            <div>
                <label>Zip:
                    <select id="register_zip" name="zip" value="">
                        <option value="" disabled="disabled">-- SELECT --</option>
                        <option value="1">Ain</option>
                        <option value="2">Aisne</option>
                        <option value="3">Allier</option>
                        <option value="4">Alpes-de-Haute-Provence</option>
                        <option value="5">Hautes-Alpes</option>
                        <option value="6">Alpes-Maritimes</option>
                        <option value="7">Ardèche</option>
                        <option value="8">Ardennes</option>
                        <option value="9">Ariège</option>
                        <option value="10">Aube</option>
                        <option value="11">Aude</option>
                        <option value="12">Aveyron</option>
                        <option value="13">Bouches-du-Rhône</option>
                        <option value="14">Calvados</option>
                        <option value="15">Cantal</option>
                        <option value="16">Charente</option>
                        <option value="17">Charente-Maritime</option>
                        <option value="18">Cher</option>
                        <option value="19">Corrèze</option>
                        <option value="2A">Corse-du-Sud</option>
                        <option value="2B">Haute-Corse</option>
                        <option value="21">Côte-d'Or</option>
                        <option value="22">Côtes-d'Armor</option>
                        <option value="23">Creuse</option>
                        <option value="24">Dordogne</option>
                        <option value="25">Doubs</option>
                        <option value="26">Drôme</option>
                        <option value="27">Eure</option>
                        <option value="28">Eure-et-Loir</option>
                        <option value="29">Finistère</option>
                        <option value="30">Gard</option>
                        <option value="31">Haute-Garonne</option>
                        <option value="32">Gers</option>
                        <option value="33">Gironde</option>
                        <option value="34">Hérault</option>
                        <option value="35">Ille-et-Vilaine</option>
                        <option value="36">Indre</option>
                        <option value="37">Indre-et-Loire</option>
                        <option value="38">Isère</option>
                        <option value="39">Jura</option>
                        <option value="40">Landes</option>
                        <option value="41">Loir-et-Cher</option>
                        <option value="42">Loire</option>
                        <option value="43">Haute-Loire</option>
                        <option value="44">Loire-Atlantique</option>
                        <option value="45">Loiret</option>
                        <option value="46">Lot</option>
                        <option value="47">Lot-et-Garonne</option>
                        <option value="48">Lozère</option>
                        <option value="49">Maine-et-Loire</option>
                        <option value="50">Manche</option>
                        <option value="51">Marne</option>
                        <option value="52">Haute-Marne</option>
                        <option value="53">Mayenne</option>
                        <option value="54">Meurthe-et-Moselle</option>
                        <option value="55">Meuse</option>
                        <option value="56">Morbihan</option>
                        <option value="57">Moselle</option>
                        <option value="58">Nièvre</option>
                        <option value="59">Nord</option>
                        <option value="60">Oise</option>
                        <option value="61">Orne</option>
                        <option value="62">Pas-de-Calais</option>
                        <option value="63">Puy-de-Dôme</option>
                        <option value="64">Pyrénées-Atlantiques</option>
                        <option value="65">Hautes-Pyrénées</option>
                        <option value="66">Pyrénées-Orientales</option>
                        <option value="67">Bas-Rhin</option>
                        <option value="68">Haut-Rhin</option>
                        <option value="69">Rhône</option>
                        <option value="70">Haute-Saône</option>
                        <option value="71">Saône-et-Loire</option>
                        <option value="72">Sarthe</option>
                        <option value="73">Savoie</option>
                        <option value="74">Haute-Savoie</option>
                        <option value="75">Paris</option>
                        <option value="76">Seine-Maritime</option>
                        <option value="77">Seine-et-Marne</option>
                        <option value="78">Yvelines</option>
                        <option value="79">Deux-Sèvres</option>
                        <option value="80">Somme</option>
                        <option value="81">Tarn</option>
                        <option value="82">Tarn-et-Garonne</option>
                        <option value="83">Var</option>
                        <option value="84">Vaucluse</option>
                        <option value="85">Vendée</option>
                        <option value="86">Vienne</option>
                        <option value="87">Haute-Vienne</option>
                        <option value="88">Vosges</option>
                        <option value="89">Yonne</option>
                        <option value="90">Territoire de Belfort</option>
                        <option value="91">Essonne</option>
                        <option value="92">Hauts-de-Seine</option>
                        <option value="93">Seine-Saint-Denis</option>
                        <option value="94">Val-de-Marne</option>
                        <option value="95">Val-d'Oise</option>
                    </select>
                </label>
            </div>
            <div><label>Email: <input id="register_email" type="text" maxlength="320" name="email" value="" /></label></div>
            <div><label>Password: <input id="register_password_1" type="password" maxlength="128" name="password_1" value="" /></label></div>
            <div><label>Confirm password: <input id="register_password_2" type="password" maxlength="128" name="password_2" value="" /></label></div>
            <div><input type="submit" name="submit" value="register"></div>
        </form>
        <script type="text/javascript">register_init();</script>
		<!-- END login -->

		<!-- SECTION noLogin -->
		<p>You are already logged in.</p>
		<!-- END noLogin -->

