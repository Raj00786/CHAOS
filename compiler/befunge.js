// Befunge interpreter
// Copyright 2005 Ian Osgood

// to be run from a page having fields with these ids:
//   code:  empty PRE block for showing the program execution
//   input:	single line, from which ',' gets input
//   output:	PRE block, destination for output of '.' and ','
//   stack: single line, contents of the stack

// buttons can execute these commands:
//   format:  copy program from PRE or TEXTAREA to code
//   run:     run loop that runs to completion
//   sstep:   single step and highlight current position
//     uses number from field id "repeat" to step n times
//   slow:    toggle running steps on a timer
//     sets milliseconds per step from field id "speed" 

var code = "@";     // formatted code
var width;          // length of each line in code
var ip = 0;         // current instruction within code 

function left()  { if (ip%width==0) ip += width-2; else --ip; }
function right() { if (ip%width==width-2) ip -= width-2; else ++ip; }
function up()    { ip -= width; if (ip<0) ip += code.length; }
function down()  { ip += width; if (ip>=code.length) ip -= code.length; }
function done()  { }
function reflect(dir) {
   if (dir == left) return right;
   if (dir == right) return left;
   if (dir == up) return down;
   if (dir == down) return up;
   return dir;
}

var dir = right;    // current direction (set by <>^v?_| )

var ini = 0;        // current input character (fetch with ~ &)

var stack = [];    // data stack
                   // NOTE: befunge pull() == pop() returning 0 if empty
Array.prototype.pull = function() { return this.length==0 ? 0 : this.pop() }

function put(s) {
	var text = document.getElementById("output").innerHTML + s;
	text = text.replace(/\n/g, "<br>").replace(/ /g, "&nbsp;");
	document.getElementById("output").innerHTML = text;
}
function getc() {
	var s = document.getElementById("input").value;
	return ini < s.length ? s.charCodeAt(ini++) : -1;
}
function getInt() {
	var s = document.getElementById("input").value;
	var reNum = /[\+\-]?\d+/;
	var sn = s.substring(ini);
	var pos = sn.search(reNum);
	if (pos < 0) { ini = s.length; return 0; }
	sn = sn.substring(pos);
	var num = sn.match(reNum)[0];
	ini += pos + num.length;
	return parseInt(num,10);
}
// workaround for immutable strings
function setCodeAt(i,c) {
	code = code.substring(0,i)
	     + String.fromCharCode(c)
	     + code.substring(i+1);
}

var commands = {
	'$':function() { stack.pull() },
	'[':function() { var n = stack.pull(); stack.push(n,n) },
	'=':function() { stack.push(stack.pull(),stack.pull()) },

	'+':function() { stack.push( stack.pull()+stack.pull()) },
	'-':function() { stack.push(-stack.pull()+stack.pull()) },
	'*':function() { stack.push( stack.pull()*stack.pull()) },
	'/':function() {
		var d = stack.pull(), n = stack.pull(), r = n/d;
		stack.push(r<0 ? Math.ceil(r) : Math.floor(r));
	},
	'%':function() {
		var d = stack.pull(), n = stack.pull();
		stack.push(n%d);
	},
	'!':function() { stack.push( stack.pull() ? 0 : 1 ) },
	')':function() { stack.push( stack.pull()<stack.pull() ? 1 : 0 ) },

	'>':function() { dir = right },
	'<':function() { dir = left },
	'^':function() { dir = up },
	'v':function() { dir = down },
	'o':function() { this["<>^v".charAt(Math.floor(Math.random()*4))]() },
	'_':function() { dir = stack.pull() ? left : right },
	'|':function() { dir = stack.pull() ? up : down },
 	'~':function() { dir() },

	'.':function() { put(stack.pull()+' ') },
	',':function() { put(String.fromCharCode(stack.pull())) },
	'#':function() { stack.push(getInt()) },
	'&':function() { stack.push(getc()) },

	'"':function() { body = strBody },
	'r':function() {
		var y=stack.pull(), x=stack.pull();
		stack.push(code.charCodeAt(x+y*width));
	},
	'p':function() {
		var y=stack.pull(), x=stack.pull();
		setCodeAt(x+y*width, stack.pull());
	},
	'@':function() { dir = done },
	' ':function() { },   // noops, bf98: other characters reflect ip
	'\n':function() { }
};

var spaces = "  ";
function format(id) {
	// format the buffer to evenly pad the line lengths
	var el = document.getElementById(id);
	var value = el.value || el.textContent || el.innerText;
	var lines = value.split('\n');
	width = 0;
	for (var i in lines)
		width = Math.max(width, lines[i].length);
	while (spaces.length < width)
		spaces += spaces;
	for (var i in lines)
		lines[i] += spaces.substring(0, width - lines[i].length);
	code = lines.join('\n') + '\n';		//TODO: not kosher
	width++;

	// show the formatted code in a PRE block (id=code)
	init();
	dump();
	window.scroll(0,document.getElementById("code").offsetTop);
}

function init() {
	ip = 0; dir = right; ini = 0;
	stack = [];
	body = exeBody;
	document.getElementById("output").innerHTML = "";
}

function exeBody() {
	var c = code.charAt(ip);
	if (/\d/.test(c))
		stack.push(parseInt(c,10));
	else if (commands[c])
		commands[c]();
	else
		dir = reflect(dir);
	dir();
}
var quoteCode = '"'.charCodeAt(0);
function strBody() {
	var c = code.charCodeAt(ip);
	if (c == quoteCode)
		body = exeBody;
	else
		stack.push(c);
	dir();
}
var body = exeBody;

function encode(s) {
	var e = s.replace(/&/g, "&amp;");
	    e = e.replace(/</g, "&lt;");
		e = e.replace(/>/g, "&gt;");
		e = e.replace(/ /g, "&nbsp;");
	return  e.replace(/\n/g, "<br>");
}
function dump() {
	document.getElementById("code").innerHTML = encode(code.substring(0,ip))
		+ '<span style="background: pink">'
		+ encode(code.charAt(ip))
		+ '</span>'
		+ encode(code.substring(ip+1));
	document.getElementById("stack").value = stack.join();
}

var tid = 0;
function sstep() {
	var n = document.getElementById("repeat").value - 0;

	if (dir==done) init();
	while (--n>=0 && dir!=done)
		body();

	if (dir==done && tid) slow();	// stop timer
	dump();
}

function slow() {
	if (tid) {
		clearInterval(tid);
		tid = 0;
		document.getElementById("slow").value = "Slow";
	} else {
		var n = document.getElementById("speed").value - 0;
		tid = setInterval(sstep, Math.max(n,10));
		document.getElementById("slow").value = "Stop";
	}
}

function run() {
	if (tid) slow(); //stop timer
        if (dir==done) init();
	while (dir!=done)
		body();
	dump();
}
