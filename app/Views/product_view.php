<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=d    <audio id="clickSound" preload="auto">
    <title>PRODUCT SHOP - RETRO</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Press Start 2P', monospace;
            background: #1a1a2e;
            color: #eee;
            font-size: 12px;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('<?= base_url('assets/images/background.jpg') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.5;
            z-index: -1;
        }
        
        .container {
            max-width: 800px;
            min-width: 500px;
            min-height: 600px;
            padding: 20px;
            background: #16213e;
            border: 4px solid #0f3460;
        }
        
        .header {
            text-align: center;
            padding: 15px;
            background: #0f3460;
            margin-bottom: 15px;
            border: 2px solid #eee;
        }
        
        .title { color: #e94560; text-shadow: 2px 2px 0px #000; margin-bottom: 10px; }
        
        .btn {
            background: #e94560;
            color: #fff;
            border: 2px solid #fff;
            padding: 8px 12px;
            cursor: pointer;
            font-family: inherit;
            font-size: 10px;
            margin: 3px;
            transition: all 0.2s;
        }
        
        .btn:hover { background: #fff; color: #e94560; }
        
        .product-list {
            background: #0f3460;
            border: 2px solid #eee;
            padding: 15px;
            min-height: 500px;
            margin-bottom: 15px;
        }
        
        .product-item {
            background: #1a1a2e;
            border: 1px solid #eee;
            padding: 10px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .product-info { flex: 1; }
        .product-name { color: #e94560; margin-bottom: 5px; }
        .product-description { 
            font-size: 8px; 
            opacity: 0.8; 
            margin-bottom: 5px;
        }
        .product-price { color: #0ff; }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 1000;
        }
        
        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #16213e;
            border: 4px solid #eee;
            padding: 20px;
            max-width: 400px;
            width: 90%;
        }
        
        .close { float: right; font-size: 16px; cursor: pointer; color: #e94560; }
        label { display: block; margin: 5px 0; color: #eee; }
        input, textarea {
            width: 100%;
            padding: 6px;
            background: #1a1a2e;
            border: 1px solid #eee;
            color: #eee;
            font-family: inherit;
            font-size: 10px;
            margin-bottom: 10px;
        }
        .success { color: #0f0; }
        .error { color: #f00; }
    </style>
</head>
<body>
    <!-- Custom Audio Elements -->
    <audio id="successSound" preload="auto" volume="0.7">
        <source src="<?= base_url('assets/audio/success.mp3') ?>" type="audio/mpeg">
        <source src="<?= base_url('assets/audio/success.wav') ?>" type="audio/wav">
    </audio>
    <audio id="hoverSound" preload="auto" volume="0.3">
        <source src="<?= base_url('assets/audio/hover.mp3') ?>" type="audio/mpeg">
        <source src="<?= base_url('assets/audio/hover.wav') ?>" type="audio/wav">
    </audio>
    <audio id="errorSound" preload="auto" volume="0.6">
        <source src="<?= base_url('assets/audio/error.mp3') ?>" type="audio/mpeg">
        <source src="<?= base_url('assets/audio/error.wav') ?>" type="audio/wav">
    </audio>
    <audio id="cancelSound" preload="auto" volume="0.4">
        <source src="<?= base_url('assets/audio/cancel.mp3') ?>" type="audio/mpeg">
        <source src="<?= base_url('assets/audio/cancel.wav') ?>" type="audio/wav">
    </audio>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1 class="title">🎮 PRODUCT CRUD 🎮</h1>
            <button class="btn" onclick="openModal('addModal')">+ ADD PRODUCT</button>
        </div>

        <!-- Products List -->
        <div class="product-list">
            <h2>📦 INVENTORY (<?= count($products) ?> ITEMS)</h2>
            <br>
            <?php if (empty($products)): ?>
                <div style="text-align: center; padding: 40px;">
                    <p>NO PRODUCTS FOUND!</p>
                    <p>START ADDING ITEMS TO YOUR SHOP</p>
                </div>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-item">
                        <div class="product-info">
                            <div class="product-name">⚡ <?= esc($product['product_name']) ?></div>
                            <div class="product-description"><?= esc($product['description']) ?></div>
                            <div class="product-price">💰 PHP <?= number_format($product['price'], 2) ?></div>
                        </div>
                        <div>
                            <button class="btn btn-small" onclick="editProduct(<?= $product['id'] ?>, '<?= htmlspecialchars($product['product_name'], ENT_QUOTES) ?>', '<?= htmlspecialchars($product['description'], ENT_QUOTES) ?>', <?= $product['price'] ?>)">EDIT</button>
                            <button class="btn btn-small" onclick="deleteProduct(<?= $product['id'] ?>, '<?= htmlspecialchars($product['product_name'], ENT_QUOTES) ?>')">DELETE</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="playCancel(); closeModal('addModal')">&times;</span>
            <h3>ADD NEW PRODUCT</h3><br>
            <form method="post" action="<?= base_url('products/create'); ?>">
                <div class="form-group">
                    <label>PRODUCT NAME:</label>
                    <input type="text" name="product_name" required>
                </div>
                <div class="form-group">
                    <label>DESCRIPTION:</label>
                    <textarea name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>PRICE:</label>
                    <input type="number" step="0.01" name="price" required>
                </div>
                <button type="submit" class="btn">ADD PRODUCT</button>
                <button type="button" class="btn" onclick="playCancel(); closeModal('addModal')">CANCEL</button>
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="playCancel(); closeModal('editModal')">&times;</span>
            <h3>EDIT PRODUCT</h3><br>
            <form method="post" id="editForm">
                <div class="form-group">
                    <label>PRODUCT NAME:</label>
                    <input type="text" name="product_name" id="editName" required>
                </div>
                <div class="form-group">
                    <label>DESCRIPTION:</label>
                    <textarea name="description" id="editDesc" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>PRICE:</label>
                    <input type="number" step="0.01" name="price" id="editPrice" required>
                </div>
                <button type="submit" class="btn">UPDATE</button>
                <button type="button" class="btn" onclick="playCancel(); closeModal('editModal')">CANCEL</button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="playCancel(); closeModal('deleteModal')">&times;</span>
            <h3>DELETE PRODUCT</h3><br>
            <p>ARE YOU SURE YOU WANT TO DELETE:</p>
            <p class="error" id="deleteProductName"></p><br>
            <p>THIS ACTION CANNOT BE UNDONE!</p><br>
            <a href="#" id="deleteLink" class="btn">DELETE</a>
            <button type="button" class="btn" onclick="playCancel(); closeModal('deleteModal')">CANCEL</button>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div id="feedbackModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('feedbackModal')">&times;</span>
            <h3 id="feedbackTitle">STATUS</h3><br>
            <p id="feedbackMessage"></p><br>
            <button class="btn" onclick="closeModal('feedbackModal')">OK</button>
        </div>
    </div>

    <script>
        // Audio functions with improved reliability
        function playSuccess() { 
            const audio = document.getElementById('successSound');
            audio.currentTime = 0;
            audio.play().catch(e => console.log('Success sound failed:', e)); 
        }
        function playHover() { 
            const audio = document.getElementById('hoverSound');
            audio.currentTime = 0;
            audio.play().catch(e => console.log('Hover sound failed:', e)); 
        }
        function playError() { 
            const audio = document.getElementById('errorSound');
            audio.currentTime = 0;
            audio.play().catch(e => console.log('Error sound failed:', e)); 
        }
        function playCancel() { 
            const audio = document.getElementById('cancelSound');
            audio.currentTime = 0;
            audio.play().catch(e => console.log('Cancel sound failed:', e)); 
        }
        
        // Modal functions
        function openModal(id) { document.getElementById(id).style.display = 'block'; }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }
        
        function editProduct(id, name, desc, price) {
            document.getElementById('editName').value = name;
            document.getElementById('editDesc').value = desc;
            document.getElementById('editPrice').value = price;
            document.getElementById('editForm').action = '<?= base_url('products/update/') ?>' + id;
            openModal('editModal');
        }
        
        function deleteProduct(id, name) {
            document.getElementById('deleteProductName').textContent = name;
            document.getElementById('deleteLink').href = '<?= base_url('products/delete/') ?>' + id;
            openModal('deleteModal');
        }
        
        function showFeedback(type, message) {
            document.getElementById('feedbackTitle').textContent = type.toUpperCase();
            document.getElementById('feedbackMessage').textContent = message;
            document.getElementById('feedbackMessage').className = type;
            openModal('feedbackModal');
            // Play audio after modal opens for better reliability
            setTimeout(() => {
                if (type === 'success') playSuccess();
                if (type === 'error') playError();
            }, 100);
        }
        
        // Check for messages on load
        window.onload = function() {
            const params = new URLSearchParams(window.location.search);
            if (params.get('success')) {
                const messages = { 'created': 'PRODUCT ADDED!', 'updated': 'PRODUCT UPDATED!', 'deleted': 'PRODUCT DELETED!' };
                showFeedback('success', messages[params.get('success')] || 'SUCCESS!');
            }
            if (params.get('error')) {
                const messages = { 'validation': 'INVALID INPUT!', 'not_found': 'NOT FOUND!', 'database': 'ERROR!' };
                showFeedback('error', messages[params.get('error')] || 'ERROR!');
            }
            window.history.replaceState({}, document.title, window.location.pathname);
        }
        
        // Close modal on outside click
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) event.target.style.display = 'none';
        }
        
        // Initialize audio and add hover sounds to buttons
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize audio volumes
            document.getElementById('successSound').volume = 0.7;
            document.getElementById('hoverSound').volume = 0.3;
            document.getElementById('errorSound').volume = 0.6;
            document.getElementById('cancelSound').volume = 0.4;
            
            // Add hover events
            const buttons = document.querySelectorAll('.btn, .btn-edit, .btn-delete, .modal-close');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', playHover);
            });
        });
    </script>
</body>
</html>