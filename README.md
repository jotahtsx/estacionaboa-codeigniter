<h1 class="code-line" data-line-start=0 data-line-end=1 ><a id="_EstacionaBoa__CodeIgniter_4_com_Docker_no_WSL2_0"></a>🚀 EstacionaBoa - CodeIgniter 4 com Docker no WSL2</h1>
<blockquote>
<p class="has-line-data" data-line-start="2" data-line-end="3">Setup rápido, portátil e sem dor de cabeça para desenvolvimento local.</p>
</blockquote>
<hr>
<h2 class="code-line" data-line-start=6 data-line-end=7 ><a id="_Prrequisitos_6"></a>📌 Pré-requisitos</h2>
<ul>
<li class="has-line-data" data-line-start="8" data-line-end="9">Docker e Docker Compose instalados em seu sistema.</li>
<li class="has-line-data" data-line-start="9" data-line-end="11">WSL2 configurado corretamente.</li>
</ul>
<hr>
<h2 class="code-line" data-line-start=13 data-line-end=14 ><a id="_Estrutura_do_Projeto_13"></a>📂 Estrutura do Projeto</h2>
<table class="table table-striped table-bordered">
<thead>
<tr>
<th>Diretório/Arquivo</th>
<th>Descrição</th>
</tr>
</thead>
<tbody>
<tr>
<td><code>estacionaboa-codeigniter/</code></td>
<td>Pasta principal do projeto</td>
</tr>
<tr>
<td><code>├── www/</code></td>
<td>Arquivos do CodeIgniter</td>
</tr>
<tr>
<td><code>├── docker-compose.yml</code></td>
<td>Configuração do Docker Compose</td>
</tr>
<tr>
<td><code>├── Dockerfile</code></td>
<td>Configuração do ambiente PHP e Apache</td>
</tr>
<tr>
<td><code>└── Dockerfile.phpmyadmin</code></td>
<td>Configuração do phpMyAdmin</td>
</tr>
</tbody>
</table>
<hr>
<h2 class="code-line" data-line-start=25 data-line-end=26 ><a id="_Configurao_do_Docker_25"></a>⚙️ Configuração do Docker</h2>
<h3 class="code-line" data-line-start=27 data-line-end=28 ><a id="_Arquivo_dockercomposeyml_27"></a>📄 Arquivo docker-compose.yml</h3>
<pre><code class="has-line-data" data-line-start="30" data-line-end="88" class="language-yaml">services:
  web:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: estacionaboa-web
    ports:
      - &quot;4500:80&quot;
    volumes:
      - ./www:/var/www/html
    working_dir: /var/www/html
    depends_on:
      - db
    environment:
      TZ: America/Fortaleza
    networks:
      - codeigniter

  db:
    image: mysql:8.0
    container_name: estacionaboa-db
    command: [
      '--default-authentication-plugin=mysql_native_password',
      '--character-set-server=utf8mb4',
      '--collation-server=utf8mb4_general_ci'
    ]
    restart: always
    environment:
      MYSQL_DATABASE: estacionaboa
      MYSQL_ROOT_PASSWORD: sextafeira
    volumes:
      - codeigniter_mysql_data:/var/lib/mysql
    networks:
      - codeigniter
    ports:
      - &quot;3306:3306&quot;

  phpmyadmin:
    build:
      context: .
      dockerfile: Dockerfile.phpmyadmin
    container_name: estacionaboa-phpmyadmin
    environment:
      PMA_HOST: db
      PMA_PORT: 3306
      MYSQL_ROOT_PASSWORD: jotahdev
    ports:
      - &quot;8080:80&quot;
    networks:
      - codeigniter

volumes:
  codeigniter_mysql_data:

networks:
  codeigniter:
    driver: bridge
</code></pre>
<h3 class="code-line" data-line-start=89 data-line-end=90 ><a id="_Arquivo_Docker_89"></a>📄 Arquivo Docker</h3>
<pre><code class="has-line-data" data-line-start="91" data-line-end="129" class="language-Dockerfile"><span class="hljs-built_in">FROM</span> php:<span class="hljs-number">8.1</span>-apache

<span class="hljs-comment"># Instalar dependências do sistema</span>
<span class="hljs-built_in">RUN</span> <span class="bash">apt-get update &amp;&amp; apt-get install -y     zip     unzip     libzip-dev     libpng-dev     libjpeg-dev     libfreetype6-dev     libxml2-dev     libcurl4-openssl-dev     libicu-dev     libxslt-dev     libonig-dev
</span>
<span class="hljs-comment"># Configurar e instalar extensões PHP</span>
<span class="hljs-built_in">RUN</span> <span class="bash">docker-php-ext-configure gd --with-freetype --with-jpeg     &amp;&amp; docker-php-ext-install gd intl xsl zip pdo pdo_mysql mbstring
</span>
<span class="hljs-comment"># Instalar Composer</span>
<span class="hljs-built_in">COPY</span> <span class="bash">--from=composer:latest /usr/bin/composer /usr/bin/composer
</span>
<span class="hljs-comment"># Configurar Apache</span>
<span class="hljs-built_in">RUN</span> <span class="bash">a2enmod rewrite
</span>
<span class="hljs-comment"># Criar o diretório writable</span>
<span class="hljs-built_in">RUN</span> <span class="bash">mkdir -p writable
</span>
<span class="hljs-comment"># Configurar permissões</span>
<span class="hljs-built_in">RUN</span> <span class="bash">chown -R www-data:www-data writable
</span>
<span class="hljs-comment"># Definir diretório de trabalho</span>
<span class="hljs-built_in">WORKDIR</span> <span class="bash">/var/www/html
</span>
<span class="hljs-comment"># Copiar arquivos da aplicação (CodeIgniter)</span>
<span class="hljs-built_in">COPY</span> <span class="bash">. /var/www/html
</span>
<span class="hljs-comment"># Configurar Apache para apontar para o diretório public</span>
<span class="hljs-built_in">RUN</span> <span class="bash">sed -i <span class="hljs-string">'s!/var/www/html!/var/www/html/public!g'</span> /etc/apache2/sites-available/<span class="hljs-number">000</span>-default.conf
</span>
<span class="hljs-comment"># Adicionar ServerName após configuração do Apache</span>
<span class="hljs-built_in">RUN</span> <span class="bash"><span class="hljs-built_in">echo</span> <span class="hljs-string">"ServerName localhost"</span> &gt;&gt; /etc/apache2/apache2.conf
</span>
<span class="hljs-comment"># Expor a porta 80</span>
<span class="hljs-built_in">EXPOSE</span> <span class="hljs-number">80</span>

<span class="hljs-comment"># Comando para iniciar o Apache</span>
<span class="hljs-built_in">CMD</span> <span class="bash">[<span class="hljs-string">"apache2-foreground"</span>]
</span></code></pre>
<h3 class="code-line" data-line-start=130 data-line-end=131 ><a id="_Arquivo_Docker_phpmyadmin_130"></a>📄 Arquivo Docker phpmyadmin</h3>
<pre><code class="has-line-data" data-line-start="132" data-line-end="135" class="language-Dockerfile.phpmyadmin">  FROM phpmyadmin/phpmyadmin
  RUN echo &quot;ServerName localhost&quot; &gt;&gt; /etc/apache2/apache2.conf
</code></pre>
<hr>
<h2 class="code-line" data-line-start=137 data-line-end=138 ><a id="_Instalao_e_Execuo_137"></a>🚀 Instalação e Execução</h2>
<ol>
<li class="has-line-data" data-line-start="138" data-line-end="148">
<p class="has-line-data" data-line-start="138" data-line-end="139"><strong>Clone este repositório</strong>:</p>
<pre><code class="has-line-data" data-line-start="140" data-line-end="142" class="language-sh">git <span class="hljs-built_in">clone</span> git@github.com:jotahtsx/estacionaboa-codeigniter.git
</code></pre>
<p class="has-line-data" data-line-start="142" data-line-end="143">Ou, se quiser usar o HTTPS:</p>
<pre><code class="has-line-data" data-line-start="145" data-line-end="147" class="language-sh">git <span class="hljs-built_in">clone</span> https://github.com/jotahtsx/estacionaboa-codeigniter.git
</code></pre>
</li>
<li class="has-line-data" data-line-start="148" data-line-end="153">
<p class="has-line-data" data-line-start="148" data-line-end="149"><strong>Navegue até o diretório do projeto</strong>:</p>
<pre><code class="has-line-data" data-line-start="150" data-line-end="152" class="language-sh"><span class="hljs-built_in">cd</span> estacionaboa-codeigniter
</code></pre>
</li>
<li class="has-line-data" data-line-start="153" data-line-end="158">
<p class="has-line-data" data-line-start="153" data-line-end="154"><strong>Inicie os containers</strong>:</p>
<pre><code class="has-line-data" data-line-start="155" data-line-end="157" class="language-sh">docker-compose up --build <span class="hljs-operator">-d</span>
</code></pre>
</li>
<li class="has-line-data" data-line-start="158" data-line-end="163">
<p class="has-line-data" data-line-start="158" data-line-end="159"><strong>Acesse o shell do container web</strong>:</p>
<pre><code class="has-line-data" data-line-start="160" data-line-end="162" class="language-sh">docker <span class="hljs-built_in">exec</span> -it estacionaboa-web bash
</code></pre>
</li>
<li class="has-line-data" data-line-start="163" data-line-end="167">
<p class="has-line-data" data-line-start="163" data-line-end="164"><strong>Rode o composer para instalar as dependências</strong>:</p>
<pre><code class="has-line-data" data-line-start="165" data-line-end="167" class="language-sh">composer install
</code></pre>
</li>
<li class="has-line-data" data-line-start="167" data-line-end="172">
<p class="has-line-data" data-line-start="167" data-line-end="168"><strong>Saia do container</strong>:</p>
<pre><code class="has-line-data" data-line-start="169" data-line-end="171" class="language-sh"><span class="hljs-built_in">exit</span>
</code></pre>
</li>
<li class="has-line-data" data-line-start="172" data-line-end="177">
<p class="has-line-data" data-line-start="172" data-line-end="173"><strong>Ajuste as permissões do diretório writable</strong>:</p>
<pre><code class="has-line-data" data-line-start="174" data-line-end="176" class="language-sh">docker <span class="hljs-built_in">exec</span> -it estacionaboa-web chmod -R <span class="hljs-number">777</span> /var/www/html/writable
</code></pre>
</li>
<li class="has-line-data" data-line-start="177" data-line-end="178">
<p class="has-line-data" data-line-start="177" data-line-end="178"><strong>Acesse a aplicação</strong>:</p>
</li>
</ol>
<ul>
<li class="has-line-data" data-line-start="178" data-line-end="179"><strong>Aplicação CodeIgniter</strong>: <a href="http://localhost:4500">http://localhost:4500</a></li>
<li class="has-line-data" data-line-start="179" data-line-end="181"><strong>PHPMyAdmin</strong>: <a href="http://localhost:8080">http://localhost:8080</a></li>
</ul>
<hr>
<h2 class="code-line" data-line-start=183 data-line-end=184 ><a id="_Psinstalao_configurao_do_ambiente_183"></a>✅ Pós-instalação (configuração do ambiente)</h2>
<p class="has-line-data" data-line-start="185" data-line-end="186">Dentro do container <code>estacionaboa-web</code>:</p>
<pre><code class="has-line-data" data-line-start="188" data-line-end="190" class="language-sh">docker <span class="hljs-built_in">exec</span> -it estacionaboa-web bash 
</code></pre>
<ol>
<li class="has-line-data" data-line-start="191" data-line-end="205">
<p class="has-line-data" data-line-start="191" data-line-end="192"><strong>Dar permissão de escrita no projeto (evita erros com <code>.env</code>)</strong></p>
<p class="has-line-data" data-line-start="193" data-line-end="194">Antes de qualquer coisa, certifique-se de ter permissões:</p>
<p class="has-line-data" data-line-start="195" data-line-end="196">Saia do container</p>
<pre><code class="has-line-data" data-line-start="198" data-line-end="200" class="language-bash"><span class="hljs-built_in">exit</span>
</code></pre>
<pre><code class="has-line-data" data-line-start="202" data-line-end="204" class="language-bash">sudo chown -R <span class="hljs-variable">$USER</span>:<span class="hljs-variable">$USER</span> www
</code></pre>
</li>
</ol>
<p class="has-line-data" data-line-start="205" data-line-end="207"><strong>Copiar o arquivo de ambiente</strong><br>
Novamente entre no container para criar uma cópia base do <code>.env</code> a partir do exemplo:</p>
<p class="has-line-data" data-line-start="208" data-line-end="209">Entrar no container(caso tenha esquecido… isso é preocupante se esqueceu)</p>
<pre><code class="has-line-data" data-line-start="211" data-line-end="213" class="language-sh">docker <span class="hljs-built_in">exec</span> -it estacionaboa-web bash 
</code></pre>
<p class="has-line-data" data-line-start="214" data-line-end="215">e depois…</p>
<pre><code class="has-line-data" data-line-start="217" data-line-end="219" class="language-bash">cp .env.example .env
</code></pre>
<p class="has-line-data" data-line-start="220" data-line-end="222"><strong>Definir o ambiente como <code>development</code></strong><br>
Remove o comentário e define o valor:</p>
<pre><code class="has-line-data" data-line-start="223" data-line-end="225" class="language-bash">sed -i <span class="hljs-string">'s/^#\?\s*CI_ENVIRONMENT\s*=.*/CI_ENVIRONMENT = development/'</span> .env
</code></pre>
<p class="has-line-data" data-line-start="226" data-line-end="228"><strong>Limpe o cache (caso necessário)</strong><br>
Limpa o cache e deixa a aplicação um pouco mais leve:</p>
<pre><code class="has-line-data" data-line-start="229" data-line-end="231" class="language-bash"> php spark cache:clear
</code></pre>
<p class="has-line-data" data-line-start="232" data-line-end="234"><strong>Verifique o ambiente atual</strong><br>
Confirme se o ambiente está definido corretamente como <code>development</code>:</p>
<pre><code class="has-line-data" data-line-start="235" data-line-end="237" class="language-bash">php spark env
</code></pre>
<hr>
<h2 class="code-line" data-line-start=240 data-line-end=241 ><a id="_Rodando_as_migraes_240"></a>🗓 Rodando as migrações</h2>
<p class="has-line-data" data-line-start="242" data-line-end="243">Ainda no container:</p>
<pre><code class="has-line-data" data-line-start="245" data-line-end="247" class="language-bash">php spark migrate
</code></pre>
<p class="has-line-data" data-line-start="248" data-line-end="249">Você verá algo como:</p>
<p class="has-line-data" data-line-start="250" data-line-end="252">Running all new migrations…<br>
Done migrations.</p>
<h3 class="code-line" data-line-start=253 data-line-end=254 ><a id="_Migrations_de_Pacotes_Externos_como_Settings_253"></a>📦 Migrations de Pacotes Externos (como Settings)</h3>
<p class="has-line-data" data-line-start="255" data-line-end="256">Alguns pacotes do CodeIgniter 4, como codeigniter4/settings ou codeigniter4/shield, possuem suas próprias migrations que <strong>não são executadas automaticamente</strong> com php spark migrate.</p>
<h4 class="code-line" data-line-start=257 data-line-end=258 ><a id="_Para_rodar_todas_as_migrations_inclusive_dos_pacotes_257"></a>✅ Para rodar todas as migrations (inclusive dos pacotes):</h4>
<pre><code class="has-line-data" data-line-start="259" data-line-end="261" class="language-bash">php spark migrate --all
</code></pre>
<h4 class="code-line" data-line-start=262 data-line-end=263 ><a id="_Ou_para_um_pacote_especfico_ex_Settings_262"></a>✅ Ou para um pacote específico (ex: Settings):</h4>
<pre><code class="has-line-data" data-line-start="264" data-line-end="266" class="language-bash">php spark migrate --namespace CodeIgniter\\Settings
</code></pre>
<blockquote>
<p class="has-line-data" data-line-start="267" data-line-end="268">⚠️ Lembre-se das duas barras \ no terminal para escapar corretamente o namespace.</p>
</blockquote>
<h4 class="code-line" data-line-start=269 data-line-end=270 ><a id="_Verificando_o_status_das_migrations_269"></a>🔍 Verificando o status das migrations:</h4>
<pre><code class="has-line-data" data-line-start="271" data-line-end="273" class="language-bash">php spark migrate:status
</code></pre>
<h3 class="code-line" data-line-start=274 data-line-end=275 ><a id="_Tabelas_migradas_274"></a>🗂️ Tabelas migradas</h3>
<p class="has-line-data" data-line-start="276" data-line-end="277">Você vai se deparar com as seguintes tabelas que foram criadas no banco de dados após as migrações:</p>
<table class="table table-striped table-bordered">
<thead>
<tr>
<th>Namespace</th>
<th>Versão</th>
<th>Nome do Arquivo</th>
<th>Grupo</th>
<th>Migrado em</th>
<th>Lote</th>
</tr>
</thead>
<tbody>
<tr>
<td>App</td>
<td>2025-04-08-194938</td>
<td>CreateSettingsTable</td>
<td>default</td>
<td>2025-04-08 19:50:40</td>
<td>1</td>
</tr>
<tr>
<td>CodeIgniter\Shield</td>
<td>2020-12-28-223112</td>
<td>create_auth_tables</td>
<td>default</td>
<td>2025-04-08 19:55:01</td>
<td>2</td>
</tr>
<tr>
<td>CodeIgniter\Settings</td>
<td>2021-07-04-041948</td>
<td>CreateSettingsTable</td>
<td>default</td>
<td>2025-04-08 19:55:01</td>
<td>2</td>
</tr>
<tr>
<td>CodeIgniter\Settings</td>
<td>2021-11-14-143905</td>
<td>AddContextColumn</td>
<td>default</td>
<td>2025-04-08 19:55:01</td>
<td>2</td>
</tr>
</tbody>
</table>
<p class="has-line-data" data-line-start="285" data-line-end="286">Para confirmar, essas são as seguintes tabelas que foram criadas no seu banco de dados:</p>
<ul>
<li class="has-line-data" data-line-start="287" data-line-end="288">auth_groups_users</li>
<li class="has-line-data" data-line-start="288" data-line-end="289">auth_identities</li>
<li class="has-line-data" data-line-start="289" data-line-end="290">auth_logins</li>
<li class="has-line-data" data-line-start="290" data-line-end="291">auth_permissions_users</li>
<li class="has-line-data" data-line-start="291" data-line-end="292">auth_remember_tokens</li>
<li class="has-line-data" data-line-start="292" data-line-end="293">auth_token_logins</li>
<li class="has-line-data" data-line-start="293" data-line-end="294">migrations</li>
<li class="has-line-data" data-line-start="294" data-line-end="295">settings</li>
<li class="has-line-data" data-line-start="295" data-line-end="297">users</li>
</ul>
<hr>
<p class="has-line-data" data-line-start="299" data-line-end="300">Este projeto utiliza pacotes como <code>codeigniter4/settings</code> e <code>codeigniter4/shield</code>, que <strong>já fornecem migrations próprias</strong>.</p>
<h3 class="code-line" data-line-start=301 data-line-end=302 ><a id="_O_que_voc_precisa_saber_301"></a>👉 O que você precisa saber:</h3>
<ul>
<li class="has-line-data" data-line-start="302" data-line-end="303"><strong>Não crie migrations duplicadas</strong> com nomes de tabelas que já são criadas pelos pacotes (como <code>settings</code>, <code>auth_*</code>, etc.).</li>
<li class="has-line-data" data-line-start="303" data-line-end="304">Já existe uma migration em <code>vendor/codeigniter4/settings</code> que cria a tabela <code>settings</code>. <strong>Não crie outra no seu app.</strong></li>
<li class="has-line-data" data-line-start="304" data-line-end="306">Rodar <code>php spark migrate --all</code> é obrigatório para aplicar também as migrations desses pacotes.</li>
</ul>
<h3 class="code-line" data-line-start=306 data-line-end=307 ><a id="_Para_rodar_as_migrations_corretamente_306"></a>💥 Para rodar as migrations corretamente:</h3>
<h2 class="code-line" data-line-start=307 data-line-end=308 ><a id="Este_comando_DELETA_todas_as_tabelas_do_banco_Use_com_cuidado_307"></a>Este comando DELETA todas as tabelas do banco. Use com cuidado!</h2>
<pre><code class="has-line-data" data-line-start="309" data-line-end="311" class="language-bash">php spark migrate:reset
</code></pre>
<h1 class="code-line" data-line-start=312 data-line-end=313 ><a id="Aps_resetar_rode_todas_as_migrations_novamente_312"></a>Após resetar, rode todas as migrations novamente</h1>
<pre><code class="has-line-data" data-line-start="314" data-line-end="316" class="language-bash">php spark migrate --all
</code></pre>
<hr>
<h3 class="code-line" data-line-start=319 data-line-end=320 ><a id="_Dica_do_Tio_Jo_319"></a>✅ Dica do Tio Jão</h3>
<p class="has-line-data" data-line-start="321" data-line-end="322">Se você já bagunçou todas as migrations e o banco tá parecendo um campo de batalha, segue o combo da faxina:</p>
<pre><code class="has-line-data" data-line-start="324" data-line-end="326" class="language-bash">php spark migrate:reset
</code></pre>
<pre><code class="has-line-data" data-line-start="327" data-line-end="329" class="language-bash">php spark migrate --all
</code></pre>
<h2 class="code-line" data-line-start=330 data-line-end=331 ><a id="_Onde_t_o_vacilo_330"></a>🕵️ Onde tá o vacilo?</h2>
<p class="has-line-data" data-line-start="332" data-line-end="333">Dá uma olhada em:</p>
<h2 class="code-line" data-line-start=334 data-line-end=335 ><a id="_Soluo_para_o_erro_Table_already_exists_334"></a>🛠️ Solução para o erro “Table already exists”</h2>
<p class="has-line-data" data-line-start="336" data-line-end="338">Se tiver algo com nome tipo <code>CreateSettingsTable.php</code>, e você já usa o pacote que também cria essa tabela, então temos <strong>duas migrations querendo ser mãe da mesma tabela</strong>.<br>
Aí o MySQL pira com razão.</p>
<hr>
<h3 class="code-line" data-line-start=341 data-line-end=342 ><a id="_Soluo_para_no_bater_o_carro_341"></a>🛠️ Solução para não bater o carro</h3>
<ul>
<li class="has-line-data" data-line-start="343" data-line-end="344">Apaga ou renomeia a migration duplicada.</li>
<li class="has-line-data" data-line-start="344" data-line-end="346"><strong>Respira.</strong></li>
</ul>
<hr>
<ul>
<li class="has-line-data" data-line-start="348" data-line-end="350">Roda com orgulho:</li>
</ul>
<pre><code class="has-line-data" data-line-start="351" data-line-end="353" class="language-bash">php spark migrate --all
</code></pre>
<hr>
<h2 class="code-line" data-line-start=355 data-line-end=356 ><a id="_A_DICA_ASSOMBRADA_DO_DEV_MALDITO_355"></a>☠️ A DICA ASSOMBRADA DO DEV MALDITO™</h2>
<blockquote>
<p class="has-line-data" data-line-start="357" data-line-end="359"><strong>Você achou que tinha apagado tudo… mas ela voltou.</strong><br>
A maldição da tabela <code>settings</code> ainda vive! 😱</p>
</blockquote>
<hr>
<h3 class="code-line" data-line-start=362 data-line-end=363 ><a id="_O_SINAL_DO_ERRO_362"></a>👁️‍🗨️ O SINAL DO ERRO</h3>
<p class="has-line-data" data-line-start="363" data-line-end="364">Se ao rodar o ritual:</p>
<pre><code class="has-line-data" data-line-start="365" data-line-end="367" class="language-bash">php spark migrate --all
</code></pre>
<p class="has-line-data" data-line-start="367" data-line-end="368">Table ‘settings’ already exists</p>
<p class="has-line-data" data-line-start="369" data-line-end="370">⚰️ É tarde demais. Você despertou a duplicação proibida.</p>
<hr>
<h2 class="code-line" data-line-start=373 data-line-end=374 ><a id="_Configuraes_Adicionais_373"></a>🔧 Configurações Adicionais</h2>
<ul>
<li class="has-line-data" data-line-start="375" data-line-end="376"><strong>Banco de Dados</strong>: Edite app/Config/Database.php com as credenciais do MySQL.</li>
<li class="has-line-data" data-line-start="376" data-line-end="378"><strong>Arquivo .env</strong>: Copie .env.example para .env e ajuste as variáveis.</li>
</ul>
<hr>
<h2 class="code-line" data-line-start=380 data-line-end=381 ><a id="_Soluo_de_Problemas_380"></a>🛠 Solução de Problemas</h2>
<h3 class="code-line" data-line-start=382 data-line-end=383 ><a id="_Whoops_We_seem_to_have_hit_a_snag_382"></a>❌ “Whoops! We seem to have hit a snag…”</h3>
<ol>
<li class="has-line-data" data-line-start="384" data-line-end="386">Verifique permissões do diretório writable:</li>
</ol>
<p class="has-line-data" data-line-start="386" data-line-end="387">&lt;pre&gt; <code>bash docker exec -it estacionaboa-web chmod -R 777 /var/www/html/writable</code> &lt;/pre&gt;</p>
<ol start="2">
<li class="has-line-data" data-line-start="388" data-line-end="389">Verifique as configurações do banco de dados.</li>
<li class="has-line-data" data-line-start="389" data-line-end="390">Verifique logs em writable/logs.</li>
<li class="has-line-data" data-line-start="390" data-line-end="391">Verifique se as extensões PHP necessárias estão instaladas.</li>
<li class="has-line-data" data-line-start="391" data-line-end="393">Verifique o arquivo .env.</li>
</ol>
<h3 class="code-line" data-line-start=393 data-line-end=394 ><a id="_Forbidden_393"></a>❌ “Forbidden”</h3>
<ol>
<li class="has-line-data" data-line-start="395" data-line-end="396">Verifique permissões de arquivos e diretórios.</li>
<li class="has-line-data" data-line-start="396" data-line-end="397">Verifique configuração do Apache e .htaccess.</li>
<li class="has-line-data" data-line-start="397" data-line-end="399">Certifique-se de acessar o diretório public.</li>
</ol>
<hr>
<h3 class="code-line" data-line-start=401 data-line-end=402 ><a id="_Notas_Importantes_401"></a>⚠️ Notas Importantes</h3>
<h4 class="code-line" data-line-start=403 data-line-end=404 ><a id="_Permisso_da_pasta_www_403"></a>🛠 Permissão da pasta www</h4>
<p class="has-line-data" data-line-start="405" data-line-end="406">Caso você não consiga editar os arquivos da pasta www/ no seu host (por exemplo, erros de permissão ao tentar salvar arquivos), isso pode estar relacionado ao fato de o container Docker ter criado os arquivos com outro usuário.</p>
<p class="has-line-data" data-line-start="407" data-line-end="408">Para resolver, execute o comando abaixo no terminal:</p>
<p class="has-line-data" data-line-start="409" data-line-end="411">bash<br>
sudo chown -R $USER:$USER www</p>
<hr>
<h1 class="code-line" data-line-start=414 data-line-end=415 ><a id="_Dvidas_Frequentes_414"></a>❓ Dúvidas Frequentes</h1>
<hr>
<p class="has-line-data" data-line-start="418" data-line-end="420"><strong>Q: Não consigo acessar o phpMyAdmin. O que faço?</strong><br>
A: Verifique se o container está rodando com <code>docker ps</code> e se a porta <code>8080</code> está livre no seu sistema.</p>
<hr>
<p class="has-line-data" data-line-start="423" data-line-end="425"><strong>Q: Minha aplicação mostra erro 500.</strong><br>
A: Rode <code>docker logs estacionaboa-web</code> para verificar o erro. Também confira se o diretório <code>writable/</code> tem permissões corretas (<code>chmod -R 777</code> como último recurso).</p>
<hr>
<p class="has-line-data" data-line-start="428" data-line-end="430"><strong>Q: O comando <code>php spark migrate</code> não faz nada.</strong><br>
A: Tente usar <code>php spark migrate --all</code> para garantir que as migrations dos pacotes externos sejam executadas.</p>
<hr>
<p class="has-line-data" data-line-start="433" data-line-end="435"><strong>Q: Recebo o erro “Table ‘settings’ already exists” ao migrar.</strong><br>
A: O pacote <code>codeigniter4/settings</code> já cria essa tabela. Remova sua migration duplicada <code>CreateSettingsTable</code>.</p>
<hr>
<p class="has-line-data" data-line-start="438" data-line-end="440"><strong>Q: Como limpo e recrio todas as tabelas do banco de dados?</strong><br>
A: Use:</p>
<pre><code class="has-line-data" data-line-start="441" data-line-end="449" class="language-bash">php spark migrate:reset
php spark migrate --all

---

<span class="hljs-comment">### 🤝 Contribuição</span>

Contribuições são bem-vindas! Sinta-se à vontade para abrir **issues** ou **pull requests**. 
</code></pre>