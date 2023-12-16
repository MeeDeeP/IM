const {createApp} = Vue;

createApp({
    data(){
        return{
            username:"",
            password:"",
        }
    },
    methods:{
        fnLogin:function(e){
            const vm = this;
            e.preventDefault();    
            const data = new FormData();
            data.append('choice','login');
            data.append('username',vm.username);
            data.append('password',vm.password);
            axios.post('model/router.php',data)
            .then(function(r){
                if(r.data == 1){
                    window.location.href = 'afterindex.php';
                }
                else if(r.data == 2){
                    window.location.href = 'dashboard.php';
                }
                else if(r.data == "404"){
                    alert('Invalid Username or Password');
                }
                else if(r.data == "403"){
                    alert('Access denied');
                }
                
            })
        },
        
    },
    created:function(){
        
    }
}).mount('#login-app')