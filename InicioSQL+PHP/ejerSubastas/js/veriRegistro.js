let btn = document.getElementById('boton');
let eleEscribir = document.getElementById('error');

const verificar = (x) => { 
    let contra = document.querySelector('input[name="password"]').value;
    let contra2 = document.querySelector('input[name="passwordDeNuevo"]').value;
    if (contra != contra2) {
        x.preventDefault();
        eleEscribir.innerHTML =  "<p style='color:red;'>ERROR: FORMATO INVALIDO.</p>";
    }
    //eleEscribir.innerHTML =  "<p style='color:green;'>VALIDACION: TODO CORRECTO.</p>"; No hace efecto porque va al submit.
}
btn.addEventListener('click', verificar);