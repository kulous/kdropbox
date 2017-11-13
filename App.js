  var App = {
	uc:  0,
        content:  "",
	t: [],
	genHash: function(){
		this.hash = Math.random().toString(36).substr(2, 9);
	},
        sendFile:  function(file) {
		var me = this;
                console.log(file);
                var ul = document.getElementById('status');
                this.uc += 1;
                var d = 'upload'+this.uc;
                var li = document.createElement("li");
                ul.appendChild(li);
                li.textContent = 'Uploading ' + file.name;
                var uri = "post.php?hash=" + this.hash,
                	xhr = new XMLHttpRequest(),
                	fd = new FormData();

            xhr.open("POST", uri, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState==4 && xhr.status==200){
                        me.content += xhr.responseText + "\n";
			me.t.push(xhr.responseText);
                }
                li.innerHTML = xhr.responseText;
            };
            fd.append('myFile', file);
            fd.append('fileName', file.name);
            // Initiate a multipart/form-data upload
            xhr.send(fd);
        },
	setHash: function(hash){
		this.hash = hash;
	},
        init: function() {
		this.genHash();
		var me = this;
          	window.onload = function() {
            		this.dropzone = document.getElementById("dropzone");
            		this.dropzone.ondragover = dropzone.ondragenter = function(event) {
                		event.stopPropagation();
                		event.preventDefault();
            		}

            		this.dropzone.ondrop = function(event) {
                		event.stopPropagation();
                		event.preventDefault();

                		var filesArray = event.dataTransfer.files;
                		for (var i=0; i<filesArray.length; i++) {
                    			me.sendFile(filesArray[i]);
                		}
            		}
          	}
        },
	sendmail: function(){
		var me = this;
		event.preventDefault();
                var form = document.getElementById('mailme'),
                	uri = form.getAttribute("action");
                	xhr = new XMLHttpRequest(),
                	fd = new FormData(),
                	ul = document.getElementById('status'),
                	li = ul.children;
                if (li.length < 1) {
                        alert("There are no links to email.");
                }
                else{
                        if(document.getElementsByTagName('input')[0].value != ''){
                                fd.append('email',document.getElementsByTagName('input')[0].value);
                                fd.append('content',me.content);
                                xhr.open("POST", uri, true);
                                xhr.onreadystatechange = function() {
                                        if (xhr.readyState==4 && xhr.status==200){
                                                alert(xhr.responseText);
                                        }
                                };
                                xhr.send(fd);
                        }
                        else{
                                alert("Please enter an email address");
                        }
                }
        }
}
