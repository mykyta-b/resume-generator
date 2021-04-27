/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import Vue from 'vue';
import VueRouter from 'vue-router'
import githubUsernameRegex from 'github-username-regex';
// start the Stimulus application
import './bootstrap';

const app = new Vue({
    el: '#run',
    data: {
        errors: [],
        gitname: null,
        disabled: false,
        form: {
            action: '/',
        },
    },
    methods:{
        checkForm: function (e) {
            this.errors = [];

            if (!this.gitname) {
                this.errors.push('User name is empty');
            }

            if (!githubUsernameRegex.test(this.gitname)) {
                this.errors.push('Username may only contain alphanumeric characters or single hyphens, and cannot begin or end with a hyphen.');
            }

            if (this.errors.length === 0 ) {
                window.location = `/${this.gitname}`;
            }
            e.stopPropagation();
            e.preventDefault();


        }
    }
});
