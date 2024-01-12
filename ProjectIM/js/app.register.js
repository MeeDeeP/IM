const {createApp} = Vue;

createApp({
    data(){
        return{
            users:[],
            userid:0,
            firstname:'',
            lastname:'',
            username:'',
            password:'',
            address:'',
            email:'',
            user_role:'1',
            counterlock: 0
        }
    },
    methods:{
    
        fnUnlockAccount:function(userid){
            const vm = this;   
            const data = new FormData();
            data.append("userid",userid);
            data.append('method','fnUnlockAccount');
            axios.post('model/userModel.php',data)
            .then(function(r){
                alert('Account is unlocked');
                vm.fnGetUsers(0);
            })
        },
        fnSave:function(e){
            const vm = this;
            e.preventDefault();
            const data = new FormData();
            data.append('choice','register');
            data.append("userid",this.userid);
            data.append("firstname",this.firstname);
            data.append("lastname",this.lastname);
            data.append("username",this.username);
            data.append("password",this.password);
            data.append("address",this.address);
            data.append("email",this.email);
            data.append("user_role",this.user_role);
            axios.post('model/router.php',data)
            .then(function(r){
                if(r.data == "200"){
                    alert("User successfully saved");
                    window.location.href="login.php"
                }
                else{
                    alert('There was an error.');
                }
            })
        },
        fnUpdate:function(e){
            const vm = this;
            e.preventDefault();
            const data = new FormData();
            data.append('choice', 'update');
            data.append("userid",this.userid);
            data.append("firstname", this.firstname);
            data.append("lastname",this.lastname);
            data.append("username",this.username);
            data.append("address",this.address);
            data.append("email",this.email);
            data.append("user_role",this.user_role);
            data.append("counterlock",this.counterlock);
            axios.post('model/router.php' ,data)
            .then(function(r) {
                if(r.data == "200"){
                    alert("User Successfully Updated");
                    window.location.href="UserList.php";
                }
                else{
                    alert('There was an error');
                }
            })
        },
        DeleteUser:function(userid){
            if(confirm("Are you sure you want to delete this user?")){
                window.location.href = 'UserList.php';
                const data = new FormData();
                const vm = this;
                data.append("method","DeleteUser");
                data.append("userid",userid);
               axios.post('model/userModel.php',data)
                .then(function(r){
                    vm.fnGetUsers();
                })
            }
        },
        fnGetUsers:function(userid){
            const vm = this;
            const data = new FormData();
            data.append("method","fnGetUsers");
            data.append("userid",userid);
            axios.post('model/userModel.php',data)
            .then(function(r){
                if(userid == 0){
                    vm.users = [];
                    
                    r.data.forEach(function(v){
                        
                            vm.users.push({
                                firstname: v.firstname,
                                lastname: v.lastname,
                                username: v.username,
                                address: v.address,
                        
                                email: v.email,
                                user_role: v.user_role,
                                datecreated : v.date_created,
                                userid:v.userid,
                                counterlock: v.counterlock
                            })
                                            
                        
                    })
                }
                else{
                    r.data.forEach(function(v){
                        vm.firstname = v.firstname;
                        vm.lastname = v.lastname;
                        vm.username = v.username;
                         vm.address = v.address;
                        vm.email = v.email;
                        vm.user_role = v.user_role;
                        vm.counterlock = v.counterlock;
                        vm.userid = v.userid;
                    })
                }
            })
        }
    },
  

    created:function(){
        this.fnGetUsers(0);
    }
}).mount('#register-app')