<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>FormForce Builder</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            @keyframes spin { to { transform: rotate(360deg); } }
            .animate-spin { animation: spin 1s linear infinite; }
            body { overflow: hidden; }
        </style>
    </head>
    <body class="bg-[#0f172a] text-white">
        <!-- Top Navigation -->
        <nav class="sticky top-0 z-50 border-b border-[#334155] bg-[#0f172a] px-6 py-4">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-bold text-white">⚡ FormForce AI</h1>
                <a href="/dashboard" class="text-sm text-gray-300 hover:text-white transition-colors">
                    ← Back to Dashboard
                </a>
            </div>
        </nav>

        <!-- Two-Column Layout -->
        <div class="flex h-[calc(100vh-73px)]">
            <!-- LEFT PANEL - AI Chat (40%) -->
            <section class="flex w-[40%] flex-col bg-[#1e293b]">
                <!-- Chat Header -->
                <div class="border-b border-[#334155] px-6 py-6">
                    <h2 class="text-2xl font-bold text-white">🤖 AI Form Builder</h2>
                    <p class="mt-1 text-sm text-gray-400">Describe your form in plain English</p>
                </div>

                <!-- Chat Messages Area -->
                <div id="chatMessages" class="flex-1 overflow-y-auto px-6 py-6">
                    <!-- Empty State -->
                    <div id="chatEmptyState" class="flex h-full flex-col items-center justify-center text-center">
                        <div class="text-6xl mb-4">🤖</div>
                        <p class="text-gray-400">Start by describing the form you want to build...</p>
                    </div>
                </div>

                <!-- Chat Input Area -->
                <div class="border-t border-[#334155] bg-[#1e293b] px-6 py-6">
                    <div class="space-y-3">
                        <textarea
                            id="promptInput"
                            rows="3"
                            class="w-full resize-none rounded-xl border border-[#334155] bg-[#0f172a] px-4 py-3 text-white placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g., Create a contact form with name, email, and message..."
                        ></textarea>
                        <button
                            id="generateBtn"
                            class="w-full rounded-xl bg-gradient-to-r from-[#3b82f6] to-[#6366f1] px-4 py-3 font-bold text-white transition-all hover:brightness-110 disabled:cursor-not-allowed disabled:opacity-50"
                            type="button"
                        >
                            <span id="generateBtnText">⚡ Generate Form</span>
                            <span id="generateBtnLoading" class="hidden">
                                <span class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
                                Generating...
                            </span>
                        </button>
                        <button
                            id="clearChatBtn"
                            class="w-full text-center text-sm text-gray-400 hover:text-white transition-colors"
                            type="button"
                        >
                            Clear conversation
                        </button>
                    </div>
                </div>
            </section>

            <!-- RIGHT PANEL - Form Preview (60%) -->
            <section class="flex w-[60%] flex-col bg-white overflow-y-auto">
                <!-- Preview Header -->
                <div class="sticky top-0 z-10 border-b border-gray-200 bg-white px-8 py-6">
                    <h2 class="text-2xl font-bold text-gray-900">Form Preview</h2>
                </div>

                <!-- Preview Content -->
                <div class="flex-1 px-8 py-8">
                    <!-- Empty State -->
                    <div id="emptyState" class="flex h-full flex-col items-center justify-center text-center">
                        <div class="text-6xl mb-4">📋</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Your form will appear here</h3>
                        <p class="text-gray-500">Generate a form on the left to see a live preview</p>
                    </div>

                    <!-- Form Preview Area -->
                    <div id="formPreviewWrapper" class="hidden space-y-6">
                        <!-- Form Title Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Form Title</label>
                            <input
                                type="text"
                                id="formTitleInput"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter form title..."
                            />
                        </div>

                        <!-- Form Title Display -->
                        <div>
                            <h3 id="formTitle" class="text-3xl font-bold text-gray-900"></h3>
                            <p id="formDescription" class="mt-2 text-gray-600"></p>
                        </div>

                        <hr class="border-gray-200" />

                        <!-- Form Fields -->
                        <div id="formPreview" class="space-y-4"></div>

                        <!-- Save Button -->
                        <button
                            id="saveFormBtn"
                            class="w-full rounded-xl bg-[#0f172a] px-6 py-3 font-bold text-white transition-all hover:brightness-110"
                            type="button"
                        >
                            💾 Save this Form
                        </button>
                    </div>
                </div>
            </section>
        </div>

        <script>
            const chatMessages = document.getElementById("chatMessages");
            const chatEmptyState = document.getElementById("chatEmptyState");
            const promptInput = document.getElementById("promptInput");
            const generateBtn = document.getElementById("generateBtn");
            const generateBtnText = document.getElementById("generateBtnText");
            const generateBtnLoading = document.getElementById("generateBtnLoading");
            const clearChatBtn = document.getElementById("clearChatBtn");
            const formPreview = document.getElementById("formPreview");
            const formPreviewWrapper = document.getElementById("formPreviewWrapper");
            const emptyState = document.getElementById("emptyState");
            const formTitle = document.getElementById("formTitle");
            const formDescription = document.getElementById("formDescription");
            const formTitleInput = document.getElementById("formTitleInput");
            const saveFormBtn = document.getElementById("saveFormBtn");
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            let latestSchema = null;

            const appendMessage = (content, sender) => {
                // Hide empty state when first message is added
                if (chatEmptyState) {
                    chatEmptyState.style.display = "none";
                }

                if (sender === "user") {
                    const bubble = document.createElement("div");
                    bubble.className = "ml-auto max-w-[80%] rounded-2xl bg-[#3b82f6] px-4 py-3 text-sm text-white";
                    bubble.textContent = content;
                    chatMessages.appendChild(bubble);
                } else {
                    const aiWrapper = document.createElement("div");
                    aiWrapper.className = "mr-auto max-w-[80%]";

                    const aiLabel = document.createElement("div");
                    aiLabel.className = "mb-1 text-xs text-gray-400";
                    aiLabel.textContent = "✦ FormForce AI";

                    const bubble = document.createElement("div");
                    bubble.className = "rounded-2xl bg-[#334155] px-4 py-3 text-sm text-white";
                    bubble.textContent = content;

                    aiWrapper.appendChild(aiLabel);
                    aiWrapper.appendChild(bubble);
                    chatMessages.appendChild(aiWrapper);
                }

                chatMessages.scrollTop = chatMessages.scrollHeight;
            };

            const setLoading = (isLoading) => {
                if (isLoading) {
                    generateBtnText.classList.add("hidden");
                    generateBtnLoading.classList.remove("hidden");
                    generateBtn.setAttribute("disabled", "disabled");
                } else {
                    generateBtnText.classList.remove("hidden");
                    generateBtnLoading.classList.add("hidden");
                    generateBtn.removeAttribute("disabled");
                }
            };

            const buildFormHTML = (formData) => {
                if (!formData || !Array.isArray(formData.fields)) {
                    return "";
                }

                const form = document.createElement("form");
                form.className = "space-y-5";

                formData.fields.forEach((field) => {
                    const wrapper = document.createElement("div");
                    wrapper.className = "space-y-2";

                    const label = document.createElement("label");
                    label.className = "block text-sm font-semibold text-gray-700";
                    
                    const labelText = field.label || "Field";
                    const requiredMark = field.required ? '<span class="text-red-500">*</span>' : '';
                    label.innerHTML = labelText + ' ' + requiredMark;

                    let inputElement = null;

                    if (field.type === "textarea") {
                        inputElement = document.createElement("textarea");
                        inputElement.rows = 3;
                    } else if (field.type === "select") {
                        inputElement = document.createElement("select");
                        const options = Array.isArray(field.options) ? field.options : [];
                        options.forEach((optionValue) => {
                            const option = document.createElement("option");
                            option.value = optionValue;
                            option.textContent = optionValue;
                            inputElement.appendChild(option);
                        });
                    } else if (field.type === "checkbox" || field.type === "radio") {
                        inputElement = document.createElement("div");
                        inputElement.className = "space-y-2";
                        const options = Array.isArray(field.options) ? field.options : ["Yes"];
                        options.forEach((optionValue) => {
                            const optionWrapper = document.createElement("label");
                            optionWrapper.className = "flex items-center gap-2 text-sm text-gray-700 cursor-pointer";

                            const optionInput = document.createElement("input");
                            optionInput.type = field.type;
                            optionInput.name = field.name || field.label || "option";
                            optionInput.value = optionValue;
                            optionInput.disabled = true;
                            optionInput.className = "h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded";

                            const optionText = document.createElement("span");
                            optionText.textContent = optionValue;

                            optionWrapper.appendChild(optionInput);
                            optionWrapper.appendChild(optionText);
                            inputElement.appendChild(optionWrapper);
                        });
                    } else {
                        inputElement = document.createElement("input");
                        inputElement.type = field.type || "text";
                    }

                    if (inputElement instanceof HTMLElement && inputElement.tagName !== "DIV") {
                        inputElement.className =
                            "w-full rounded-lg border border-gray-300 px-4 py-2 text-gray-900 transition-colors hover:border-blue-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500";
                        inputElement.name = field.name || "";
                        inputElement.placeholder = field.placeholder || "";
                        inputElement.disabled = true;
                    }

                    wrapper.appendChild(label);
                    wrapper.appendChild(inputElement);
                    form.appendChild(wrapper);
                });

                const submitBtn = document.createElement("button");
                submitBtn.type = "button";
                submitBtn.className = "w-full rounded-lg bg-gray-200 px-4 py-3 font-medium text-gray-500 cursor-not-allowed";
                submitBtn.textContent = "Submit (Preview Mode)";
                submitBtn.disabled = true;

                form.appendChild(submitBtn);

                return form.outerHTML;
            };

            const renderPreview = (formData) => {
                if (!formData) {
                    emptyState.classList.remove("hidden");
                    formPreviewWrapper.classList.add("hidden");
                    return;
                }

                emptyState.classList.add("hidden");
                formPreviewWrapper.classList.remove("hidden");

                formTitle.textContent = formData.title || "Untitled Form";
                formDescription.textContent = formData.description || "";
                formTitleInput.value = formData.title || "Untitled Form";
                formPreview.innerHTML = buildFormHTML(formData);
            };

            generateBtn.addEventListener("click", async () => {
                const prompt = promptInput.value.trim();
                if (!prompt) {
                    appendMessage("Please describe the form you want to build.", "ai");
                    return;
                }

                appendMessage(prompt, "user");
                promptInput.value = "";
                setLoading(true);

                try {
                    const response = await fetch("/builder/generate", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify({ prompt }),
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        throw new Error(data.error || "Something went wrong while generating the form.");
                    }

                    latestSchema = data.form;
                    appendMessage("Here is your form preview. You can edit the title and save it when ready.", "ai");
                    renderPreview(latestSchema);
                } catch (error) {
                    appendMessage(error.message, "ai");
                } finally {
                    setLoading(false);
                }
            });

            saveFormBtn.addEventListener("click", async () => {
                if (!latestSchema) {
                    return;
                }

                const customTitle = formTitleInput.value.trim();
                if (!customTitle) {
                    alert("Please enter a form title.");
                    return;
                }

                try {
                    const response = await fetch("/builder/store", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify({
                            title: customTitle,
                            schema: latestSchema,
                        }),
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        throw new Error(data.error || "Unable to save the form.");
                    }

                    window.location.href = data.redirect || "/dashboard";
                } catch (error) {
                    alert(error.message);
                }
            });

            clearChatBtn.addEventListener("click", async () => {
                chatMessages.innerHTML = "";
                if (chatEmptyState) {
                    chatEmptyState.style.display = "flex";
                }
                promptInput.value = "";
                latestSchema = null;
                renderPreview(null);

                try {
                    await fetch("/builder/clear-chat", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                    });
                } catch (error) {
                    appendMessage("Unable to clear chat history. Please try again.", "ai");
                }
            });

            // Allow Enter key to generate form (Shift+Enter for new line)
            promptInput.addEventListener("keydown", (e) => {
                if (e.key === "Enter" && !e.shiftKey) {
                    e.preventDefault();
                    generateBtn.click();
                }
            });
        </script>
    </body>
</html>
    </body>
</html>
