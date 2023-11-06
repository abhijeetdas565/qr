<!DOCTYPE html>
<html>
<head>
    <title>Image Capture Modal</title>
    <style>
        /* Styles for the modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
        }

        /* Styles for the button */
        #capture-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #0074d9;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Image Capture Modal</h1>
    <button id="capture-btn">Capture Image</button>

    <!-- The modal -->
    <div id="image-modal" class="modal">
        <div class="modal-content">
            <h2>Capture Image</h2>
            <video id="video" autoplay></video>
            <button id="capture">Capture</button>
            <canvas id="canvas" style="display: none;"></canvas>
            <img id="captured-image" style="display: none;">
            <button id="close-modal">Close</button>
        </div>
    </div>

    <script>
        const captureButton = document.getElementById("capture-btn");
        const modal = document.getElementById("image-modal");
        const video = document.getElementById("video");
        const capture = document.getElementById("capture");
        const canvas = document.getElementById("canvas");
        const capturedImage = document.getElementById("captured-image");
        const closeModal = document.getElementById("close-modal");

        // Show the modal when the "Capture Image" button is clicked
        captureButton.addEventListener("click", () => {
            modal.style.display = "block";
            startCamera();
        });

        // Close the modal
        closeModal.addEventListener("click", () => {
            modal.style.display = "none";
            stopCamera();
        });

        // Start the camera
        function startCamera() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices
                    .getUserMedia({ video: true })
                    .then(function (stream) {
                        video.srcObject = stream;
                    })
                    .catch(function (error) {
                        console.error("Error accessing the camera: " + error);
                    });
            }
        }

        // Stop the camera
        function stopCamera() {
            const stream = video.srcObject;
            if (stream) {
                const tracks = stream.getTracks();
                tracks.forEach(function (track) {
                    track.stop();
                });
                video.srcObject = null;
            }
        }

        // Capture an image from the video stream
        capture.addEventListener("click", () => {
            canvas.style.display = "block";
            video.style.display = "none";
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);
            capturedImage.src = canvas.toDataURL("image/png");
            capturedImage.style.display = "block";
        });
    </script>
</body>
</html>
