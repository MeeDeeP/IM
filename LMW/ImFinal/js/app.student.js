const {createApp} = Vue;

createApp({
    data(){
        return{
            users:[],
            userid:0,
            firstname:'',
            lastname:'',
            gender:'',
            department:''
            

        }
    },
    method:{
        createstudent:function(e){
            const vm = this;
            e.preventDefault();
            const data = new FormData();
            data.append('choice','student');
            data.append("userid",this.studid);
            data.append("firstname",this.firstname);
            data.append("lastname",this.lastname);
            data.append("gender",this.gender);
            data.append("password",this.department);
            axios.post('model/router.php',data)
            .then(function(r){
                if(r.data == "200"){
                    alert("Student successfully saved");
                    window.location.href="login.php"
                }
                else{
                    alert('There was an error.');
                }
            })
        },
        
    },
    created:function(){
        this.creatstudent();
    }
}).mount('#student-app')