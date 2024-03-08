
export default (readOnly, cannotUpload, csrf, body) => ({
        async init() {
            this.imagesToDelete = [];
            this.attachesToDelete = [];
            await Promise.all([
                /* webpackPreload: true */ import("@editorjs/editorjs"),
                import("@editorjs/header"),
                import("./attaches-override"),
                import("@editorjs/delimiter"),
                import("@editorjs/embed"),
                import("./image-override"),
                import("@editorjs/nested-list"),
                import("@editorjs/quote"),
                import("@editorjs/table"),
                import("@editorjs/text-variant-tune"),
                import("@editorjs/underline"),
                import("@editorjs/code")
            ]).then(
                ([
                    { default: EditorJS },
                    { default: header },
                    { default: attaches },
                    { default: delimiter },
                    { default: embed },
                    { default: image },
                    { default: list },
                    { default: quote },
                    { default: table },
                    { default: textVariantTune },
                    { default: underline },
                    { default: code }
                ]) => {
                    const tools = {
                        header,
                        delimiter,
                        list,
                        quote,
                        table,
                        code,
                        underline,
                        embed: {
                            class: embed,
                            config: {
                                services: {
                                    youtube: true,
                                    imgur: true,
                                    pintrest: true,
                                    scratch: {
                                        regex: /https?:\/\/scratch.mit.edu\/projects\/(\d+)/,
                                        embedUrl:
                                            "https://scratch.mit.edu/projects/<%= remote_id %>/embed",
                                        html: "<iframe height='300' scrolling='no' frameborder='no' allowtransparency='true' allowfullscreen='true' style='width: 100%;'></iframe>",
                                    },
                                },
                            },
                        },
                        textVariantTune,
                    };
                    if (!cannotUpload) {
                        tools["image"] = {
                            class: image,
                            config: {
                                endpoints: {
                                    byFile: route('upload.store'),
                                    byUrl: route('upload.store'),
                                },
                                additionalRequestHeaders: {
                                    "X-CSRF-TOKEN": csrf,
                                },
                                imagesToDelete: this.imagesToDelete,
                            },
                        };
                        tools["attaches"] = {
                            class: attaches,
                            config: {
                                endpoint: route('upload.store'),
                                additionalRequestHeaders: {
                                    "X-CSRF-TOKEN": csrf,
                                },
                                attachesToDelete: this.attachesToDelete,
                            },
                        };
                    }
                    this.editor = new EditorJS({
                        holder: this.$el,
                        data: body,
                        placeholder: "Write your story...",
                        readOnly,
                        tools,
                        tunes: ["textVariantTune"],
                        onChange: async (api, event) => {
                            this.$dispatch("editor-changed");
                            console.log(event);
                            console.log(this.imagesToDelete);
                            this.body = JSON.stringify(await api.saver.save());
                        },
                    });
                }
            );
        },

        persistDeletedImages() {
            Promise
                .allSettled([
                    ...this.imagesToDelete.map(path => window.axios.delete(route('upload.destroy'), { data: { path } })),
                    ...this.attachesToDelete.map(path => window.axios.delete(route('upload.destroy'), { data: { path } })),
                ])
                .finally(() => {
                    this.imagesToDelete.length = 0;
                    this.attachesToDelete.length = 0;
                })
        },

        async save() {
            return await this.editor.save();
        },

        async destroy() {
            this.editor.destroy();
        }
    });
