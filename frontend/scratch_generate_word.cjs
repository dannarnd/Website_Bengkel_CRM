const fs = require('fs');
const path = require('path');

const markdownFile = 'c:\\Users\\user\\.gemini\\antigravity-ide\\brain\\59a74f74-f88f-417f-b7f0-7c798767eabc\\Penjelasan_Sistem_Login.md';
const outputFile = 'c:\\laragon\\www\\Smart_Workshop\\Bahan_Presentasi_Login.doc';

let md = fs.readFileSync(markdownFile, 'utf8');

// Sangat sederhana: ubah # jadi <h1>, ## jadi <h2>, dll, dan - jadi <li>
md = md.replace(/^### (.*$)/gim, '<h3>$1</h3>');
md = md.replace(/^## (.*$)/gim, '<h2>$1</h2>');
md = md.replace(/^# (.*$)/gim, '<h1>$1</h1>');
md = md.replace(/^\- (.*$)/gim, '<ul><li>$1</li></ul>');
md = md.replace(/\n\n/g, '<br><br>');
md = md.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');
md = md.replace(/\*(.*?)\*/g, '<i>$1</i>');
md = md.replace(/`(.*?)`/g, '<code style="background:#eee;padding:2px;">$1</code>');

const htmlContent = `
<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
<meta charset='utf-8'>
<title>Penjelasan Database</title>
<style>
body { font-family: 'Arial', sans-serif; font-size: 11pt; line-height: 1.5; }
h1 { color: #2c3e50; font-size: 16pt; text-align: center; }
h2 { color: #34495e; font-size: 14pt; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
h3 { color: #16a085; font-size: 12pt; margin-top: 15px; }
ul { margin-top: 0; margin-bottom: 0; }
</style>
</head>
<body>
${md}
</body>
</html>
`;

fs.writeFileSync(outputFile, htmlContent, 'utf8');
console.log('File Word berhasil dibuat di: ' + outputFile);
