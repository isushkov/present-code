/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
// require('../css/app.css');
// import '../css/app.css';
import '../css/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

// loads the jquery package from node_modules
// var $ = require('jquery');
import $ from 'jquery';

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// import the function from greet.js (the .js extension is optional)
// ./ (or ../) means to look for a local file
// var greet = require('./greet');
import addTransaction from './add-transaction';
import removeTransaction from './remove-transaction';
import changeBudget from './change-budget.js';
import hoverTable from './hover-table.js';
