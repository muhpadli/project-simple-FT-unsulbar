$('#organisasi').change(function(){
    var organisasiID = $(this).val();    
    if(organisasiID){
        $.ajax({
           type:"GET",
           url:"getJabatan?organisasiId="+organisasiID,
           dataType: 'JSON',
           success:function(res){               
            if(res){
                $("#jabatan").empty();
                $("#jabatan").append('<option>---Pilih Jabatan---</option>');
                $.each(res,function(name,id){
                    $("#jabatan").append('<option value="'+id+'">'+name+'</option>');
                });
            }else{
               $("#jabatan").empty();
            }
           }
        });
    }else{
        $("#jabatan").empty();
    }      
   });