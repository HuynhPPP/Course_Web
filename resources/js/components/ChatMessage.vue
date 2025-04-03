<template>
    <div class="row" style=" width: 100%; ">
        <div class="col-md-2 myUser">
            <ul class="user">
                <strong>Chat List</strong>
                <hr>
                <li v-for="(user, index) in users" :key="index">
                    <a href="" @click.prevent="userMessage(user.id)">

                        <img alt="UserImage" class="userImg" v-if="user.role === 'user'"
                            :src="'/upload/user_images/' + user.photo" />
                        <img alt="UserImage" class="userImg" v-else=""
                            :src="'/upload/instructor_images/' + user.photo" />

                        <span class="username text-center">{{ user.name }}</span>
                    </a>
                </li>

            </ul>
        </div>

        <!-- <div class="col-md-10" v-if="allMessages.user">
            <div class="card">
                <div class="card-header text-center myrow">
                    <strong> {{ allMessages.user.name }} </strong>
                </div>
                <div class="card-body chat-msg">
                    <ul class="chat" v-for="(msg, index) in allMessages.messages" :key="index">

                        <li class="sender clearfix" v-if="allMessages.user.id === msg.sender_id">
                            <span class="chat-img left clearfix mx-2">
                                <img :src="'/upload/instructor_images/' + msg.user.photo" class="userImg"
                                    alt="userImg" />
                            </span>
                            <div class="chat-body2 clearfix">
                                <div class="header clearfix">
                                    <strong class="primary-font">{{ msg.user.name }}</strong>
                                    <small class="right text-muted">
                                        {{ msg.created_at }}
                                    </small>
                                </div>
                                <p>{{ msg.message }}</p>
                            </div>
                        </li>

                        <li class="buyer clearfix" v-else>
                            <span class="chat-img right clearfix mx-2">
                                <img :src="'/upload/user_images/' + msg.user.photo" class="userImg" alt="userImg" />
                                <div class="chat-body clearfix">
                                    <div class="header clearfix">
                                        <small class="left text-muted">{{ msg.created_at }}</small>
                                        <strong class="right primary-font">{{ msg.user.name }} </strong>
                                    </div>
                                    <p>{{ msg.message }}</p>
                                </div>
                            </span>
                        </li>

                        <li class="sender clearfix">
                            <span class="chat-img left clearfix mx-2"> </span>
                        </li>

                    </ul>
                </div>
                <div class="card-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm"
                            placeholder="Type your message here..." />
                        <span class="input-group-btn">
                            <button class="btn btn-primary">Send</button>
                        </span>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="col-md-10" v-if="allMessages.user">
            <div class="card">
                <div class="card-header text-center myrow">
                    <strong> {{ allMessages.user.name }} </strong>
                </div>
                <div class="card-body chat-msg" style="max-height: 400px; overflow-y: auto;">
                    <ul class="chat" v-for="(msg, index) in allMessages.messages" :key="index">

                        <!-- Tin nhắn của người gửi -->
                        <li class="sender clearfix" v-if="allMessages.user.id === msg.sender_id">
                            <span class="chat-img left mx-2">
                                <img :src="getUserImage(msg)" class="userImg" alt="userImg" />
                            </span>
                            <div class="chat-body2">
                                <div class="header">
                                    <strong class="primary-font">{{ msg.user.name }}</strong>
                                    <small class="text-muted float-end">
                                        {{ formatDateTime(msg.created_at) }}
                                    </small>
                                </div>
                                <p>{{ msg.message }}</p>
                            </div>
                        </li>

                        <!-- Tin nhắn của người nhận -->
                        <li class="buyer clearfix" v-else>
                            <span class="chat-img right mx-2">
                                <img :src="getUserImage(msg)" class="userImg" alt="userImg" />
                            </span>
                            <div class="chat-body2">
                                <div class="header">
                                    <small class="text-muted float-start">{{ formatDateTime(msg.created_at) }}</small>
                                    <strong class="primary-font float-end">{{ msg.user.name }}</strong>
                                </div>
                                <p>{{ msg.message }}</p>
                            </div>
                        </li>

                    </ul>
                </div>

                <div class="card-footer">
                    <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm"
                            placeholder="Type your message here..." v-model="msg" />
                        <span class="input-group-btn">
                            <button class="btn btn-primary" @click.prevent="sendMsg()">Send</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
import moment from "moment";
moment.locale("vi");
export default {
    data() {
        return {
            users: {},
            allMessages: {},
            selectedUser: '',
            msg: '',
        }
    },

    created() {
        this.getAllUser();

        setInterval(() => {
            this.userMessage(this.selectedUser);
        }, 1000);
    },

    methods: {
        getAllUser() {
            axios.get('/user-all')
                .then((res) => {
                    this.users = res.data;
                }).catch((err) => {

                });
        },

        userMessage(userId) {
            axios.get('/user-message/' + userId)
                .then((res) => {
                    this.allMessages = res.data;
                    this.selectedUser = userId;
                }).catch((err) => {

                })
        },

        sendMsg() {
            axios.post('/send-message', { receiver_id: this.selectedUser, msg: this.msg })
                .then((res) => {
                    this.msg = "";
                    this.userMessage(this.selectedUser);
                    console.log(res.data);
                }).catch((err) => {
                    this.errors = err.response.data.errors;
                })
        },

        formatDateTime(datetime) {
            return moment(datetime).format("HH:mm DD/MM/YYYY");
        },

        getUserImage(msg) {
            if (!msg.user || !msg.user.photo) {
                return '/upload/no_image.jpg'; // Ảnh mặc định nếu không có ảnh
            }

            // Kiểm tra nếu người gửi là user hiện tại
            if (msg.sender_id === this.allMessages.user.id) {
                return '/upload/instructor_images/' + msg.user.photo;
            } else {
                return '/upload/user_images/' + msg.user.photo;
            }
        },
    }

}
</script>

<style>
/* Tổng thể giao diện */
.myrow {
    background: #F9F9F9;
    padding: 20px;
}

.myUser {
    padding-top: 15px;
    overflow-y: auto;
    height: 450px;
    background: #E9EFF6;
    border-radius: 8px;
}

/* Danh sách người dùng */
.user {
    padding: 0;
}

.user li {
    list-style: none;
    margin: 10px 0;
    display: flex;
    align-items: center;
    cursor: pointer;
    padding: 10px;
    border-radius: 8px;
    transition: 0.3s;
}

.user li:hover {
    background: #D8E3F0;
}

.user li a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
}

.userImg {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

/* Hộp tin nhắn */
.chat {
    list-style: none;
    margin: 0;
    padding: 0;
}

/* Tin nhắn */
.chat li {
    display: flex;
    align-items: flex-start;
    margin-bottom: 15px;
}

/* Tin nhắn người gửi */
.chat .buyer {
    justify-content: flex-end;
    text-align: right;
}

.chat .buyer .chat-body {
    background: #007AFF;
    color: white;
    border-radius: 15px 15px 0 15px;
}

/* Tin nhắn người nhận */
.chat .sender {
    justify-content: flex-start;
    text-align: left;
}

.chat .sender .chat-body {
    background: #F1F0F0;
    color: black;
    border-radius: 15px 15px 15px 0;
}

/* Nội dung tin nhắn */
.chat-body {
    max-width: 60%;
    padding: 10px 15px;
    font-size: 14px;
    line-height: 1.5;
    word-wrap: break-word;
    display: inline-block;
}

/* Ảnh đại diện trong tin nhắn */
.chat-img {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    margin: 0 10px;
}

/* Ô nhập tin nhắn */
.chat-input {
    display: flex;
    padding: 10px;
    border-top: 1px solid #ccc;
    background: white;
}

.chat-input input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

.chat-input button {
    background: #007AFF;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    margin-left: 10px;
    cursor: pointer;
}

.chat-input button:hover {
    background: #005EC5;
}

/* Xóa float */
.clearfix {
    clear: both;
}
</style>

<!-- <style>
.username {
    color: #000;
}

.myrow {
    background: #F3F3F3;
    padding: 25px;
}

.myUser {
    padding-top: 30px;
    overflow-y: scroll;
    height: 450px;
    background: #F2F6FA;
}

.user li {
    list-style: none;
    margin-top: 20px;

}

.user li a:hover {
    text-decoration: none;
    color: red;
}

.userImg {
    height: 35px;
    border-radius: 50%;
}

.chat {
    list-style: none;
    margin: 0;
    padding: 0;
}

.chat li {
    margin-bottom: 40px;
    padding-bottom: 5px;
    margin-top: 20px;
    width: 80%;
    height: 10px;
}

.chat li .chat-body p {
    margin: 0;
}

.chat-msg {
    overflow-y: scroll;
    height: 350px;
    background: #F2F6FA;
}

.chat-msg .chat-img {
    width: 100px;
    height: 100px;
}

.chat-msg .img-circle {
    border-radius: 50%;
}

.chat-msg .chat-img {
    display: inline-block;
}

.chat-msg .chat-body {
    display: inline-block;
    max-width: 45%;
    margin-right: -73px;
    background-color: #891631;
    border-radius: 12.5px;
    padding: 15px;
}

.chat-msg .chat-body2 {
    display: inline-block;
    max-width: 80%;
    margin-left: -64px;
    background-color: #080000;
    border-radius: 12.5px;
    padding: 15px;
}

.chat-msg .chat-body strong {
    color: #0169da;
}

.chat-msg .buyer {
    text-align: right;
    float: right;
}

.chat-msg .buyer p {
    text-align: left;
}

.chat-msg .sender {
    text-align: left;
    float: left;
}

.chat-msg .left {
    float: left;
}

.chat-msg .right {
    float: right;
}

.clearfix {
    clear: both;
}
</style> -->