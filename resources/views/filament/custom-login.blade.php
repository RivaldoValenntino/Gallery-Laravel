<style>
    body {
        background-color: #0093E9;
        background-image: linear-gradient(160deg, #0093E9 0%, #80D0C7 100%);
    }

    @media screen and (min-width: 1024px) {
        main {
            position: absolute;
        }

        main:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgb(59 130 246);
            border-radius: 12px;
            z-index: -9;

            /*box-shadow: -50px 80px 4px 10px #555;*/
            -webkit-transform: rotate(7deg);
            -moz-transform: rotate(7deg);
            -o-transform: rotate(7deg);
            -ms-transform: rotate(7deg);
            transform: rotate(7deg);
        }

        .fi-logo {
            position: fixed;
            left: 100px;
            font-size: 3em;
            color: cornsilk;
        }
    }
</style>
