const fs = require('fs');
const path = require('path');

const directoryPath = 'c:\\laragon\\www\\Smart_Workshop\\frontend\\src\\views\\admin';

// Files that use confirm or alert that we need to inject imports into
function processFile(filePath) {
    let content = fs.readFileSync(filePath, 'utf8');
    let original = content;
    let modified = false;

    // 1. Replace alert(...) with toast.info(...) or toast.success/error
    // But overriding window.alert in main.js is actually safer because we don't need to import toast everywhere!
    // So we'll skip alert replacement here and handle it in main.js
    
    // 2. Replace confirm('...') with await Swal.fire(...)
    const confirmRegex = /if\s*\(\s*confirm\s*\(\s*(['"`])(.*?)\1\s*\)\s*\)/g;
    
    if (confirmRegex.test(content)) {
        content = content.replace(confirmRegex, (match, quote, message) => {
            return `if (await Swal.fire({
      title: 'Konfirmasi',
      text: \`${message}\`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#0d9488',
      cancelButtonColor: '#ef4444',
      confirmButtonText: 'Ya, Lanjutkan!',
      cancelButtonText: 'Batal'
    }).then(result => result.isConfirmed))`;
        });
        
        // Add import Swal from 'sweetalert2'; after <script setup>
        if (!content.includes("import Swal from 'sweetalert2'")) {
            content = content.replace(/<script setup>/, `<script setup>\nimport Swal from 'sweetalert2';`);
        }
        modified = true;
    }

    if (modified) {
        fs.writeFileSync(filePath, content, 'utf8');
        console.log('Modified:', filePath);
    }
}

function walkDir(dir) {
    fs.readdirSync(dir).forEach(file => {
        let fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            walkDir(fullPath);
        } else if (fullPath.endsWith('.vue')) {
            processFile(fullPath);
        }
    });
}

walkDir(directoryPath);
console.log('Done replacement.');
