    function validarFormatoFecha(campo) {
        console.log(campo);
        var date = campo.replace(/-+/g, '/'); 

        console.log('formato ' + date);
        var RegExPattern = /^\d{2,4}\/\d{1,2}\/\d{1,2}$/;
        if ((date.match(RegExPattern)) && (date!='')) {
            return true;
        }else{
            return false;
        }
    }
    function existeFecha(fecha){
          var fechaf = fecha.split("-");
          var day = fechaf[2];
          var month = fechaf[1];
          var year = fechaf[0];
          var date = new Date(year,month,'0');
          console.log("existe : "+ date);
          if(year<1995) return false;
          if((day-0)>(date.getDate()-0)){
                return false;
          }
          return true;
    } 