
 <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acesso Negado</title>
        <style>
            body {
                background-color: #001000; /* Verde escuro */
                color: #0f0; /* Verde brilhante */
                font-family: monospace;
                overflow-x: hidden; /* Para evitar barras de rolagem horizontais com a animação */
            }
            h1 {
                text-align: center;
                font-size: 2em;
                text-shadow: 0 0 5px #0f0; /* Brilho verde */
                animation: scanlines 1s linear infinite; /* Animação de linhas de varredura */

            }
            p {
                text-align: center;
                margin-top: 20px;

            }
            a {
                color: #0f0;
                text-decoration: underline;
            }
            @keyframes scanlines {
                0% {
                    background-position: 0% 0%;
                }
                100% {
                    background-position: 0% 100%;
                }

            }

            body::before { /* Linhas de Varredura */
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-image: repeating-linear-gradient(transparent, transparent 2px, rgba(0,255,0,0.1) 2px, rgba(0,255,0,0.1) 3px);
                pointer-events: none; /* Para que não interfira com os cliques */
                animation: scanlines 1s linear infinite;
            }

            body::after { /* Efeito de distorção/interferência  */
              content: "";
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAYAAACp8Z5+AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAAaSURBVHjaYmCAAGM0gIAQwAOGLIOIIjgBBoYACgGI+AAQzAwAIdlCggAAAABJRU5ErkJggg==") repeat; /* Pequeno PNG transparente com alguns pixels */
              opacity: 0.1; /* Ajuste a opacidade para controlar a intensidade */
              mix-blend-mode: overlay; /* Experimente diferentes modos de blend */
              animation: glitch 0.5s infinite steps(1);


            }
            @keyframes glitch {
              0% { transform: translate(0); }
              25% { transform: translate(-2px, 2px); }
              50% { transform: translate(0); }
              75% { transform: translate(2px, -2px); }
              100% { transform: translate(0); }
            }
        </style>
    </head>
    <body>


        <h1>Você não tem permissão para acessar esta página.</h1>
  


    </body>
    </html>
