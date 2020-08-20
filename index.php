<?php 

//echo "hola mundo";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imagen a Canvas</title>
</head>
<body style="margin:0px;font-family:arial">
    <div width="100%" style="background-color:red;height:50px;text-align:center;height:60px">
        <h1 style="margin:0px">Imagen a Canvas</h1>
    </div><br><br>
    <div width="100%" style="margin:0px 100px 0px 100px">
        <div width="30%" style="float:left">
            <h1>Sube tu imagen </h1>
            <input type="file" name="inputCarga" id="inputCarga"><br><br>
            <h1>Descarga tu nueva imagen </h1>
            <input type="button" id="downloadImg" onclick="descargarImagen()" value="Descarga la Imagen" disabled>
        </div>
        <div width="70%" style="float:left">
            <canvas id="contenidoCanvas" width="1000px" height="0px">
            </canvas>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
var contador = 0;
var contadorHeight = 0;
//Se crea array para almacenar los nombres de los archivos
var elementos = new Array();
//Se declaran variables para trabajar con el canvas
var canvas = document.getElementById("contenidoCanvas");
var ctx = canvas.getContext("2d");

//Realizamos la lectura de la imagen
document.getElementById("inputCarga").addEventListener("change", function(evt) {
    var files = evt.target.files;

    for (let i = 0, f; f = files[i]; i++) {
        if (!f.type.match('image.*')) {
            continue;
        }

        var reader = new FileReader();
        
        reader.onload = (function(theFile) {
            return function(e) {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                elementos.push(e.target.result);
                canvas.height = 0;
                contador = 0;
                contadorHeight = 0;
                for (let i = 0; i < elementos.length; i++) {
                    setHeightCanvas(elementos[i]);
                }
                document.getElementById("downloadImg").disabled = false;
            };
        })(f);

        reader.readAsDataURL(f);
    }
});

//Funcion que cambia el alto del canvas
function setHeightCanvas(imagen) {
    var img = new Image();

    img.onload = function () {
        if (img.width > canvas.width) {
            var contadornuevo = 0.99;

            do {
                var widthnuevo = img.width * contadornuevo;
                var heightnuevo = img.height * contadornuevo;
                contadornuevo -= 0.01;
            } while (widthnuevo > canvas.width);

            canvas.height += heightnuevo + contadorHeight;

            for (let i = 0; i < elementos.length; i++) {
                setImgCanvas(elementos[i]);
            }
            contadorHeight += 25;
        } else {
            canvas.height += img.height + contadorHeight;

            for (let i = 0; i < elementos.length; i++) {
                setImgCanvas(elementos[i]);
            }
            contadorHeight += 25;
        }
    }

    img.src = imagen;
}

//Funcion que inserta la imagen dentro del lienzo canvas
function setImgCanvas(imagen) {
    var img = new Image();

    img.onload = function () {
        if (img.width > canvas.width) {
            var contadornuevo = 0.99;

            do {
                var widthnuevo = img.width * contadornuevo;
                var heightnuevo = img.height * contadornuevo;
                contadornuevo -= 0.01;
            } while (widthnuevo > canvas.width);

            ctx.drawImage(img, 0, contador, widthnuevo, heightnuevo);
            contador += heightnuevo + 20;
        } else {
            ctx.drawImage(img, 0, contador);
            contador += img.height + 20;
        }
    }

    img.src = imagen;
}

function descargarImagen() {
    var newImg = canvas.toDataURL("image/png")
    var a = document.createElement("a");
    a.download = "Nueva Imagen.png";
    a.href = newImg;                                                                
    a.click();
}
</script>