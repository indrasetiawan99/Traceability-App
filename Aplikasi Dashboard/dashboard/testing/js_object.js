var myObj, x, lengthObj2, keyObj2;
myObj = {"name":"John", "age":30, "car":null};
myObj2 = {"ext1":"nothing1", "ext2":"nothing2"};
lengthObj2 = Object.keys(myObj2).length;
keyObj2 = Object.keys(myObj2);

for(var i = 0;i < lengthObj2;i++){
	myObj[keyObj2[i]] = myObj2[keyObj2[i]];
}