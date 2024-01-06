
export default (readOnly, cannotUpload, csrf, body) => ({
        async init() {
            await Promise.all([
                /* webpackPreload: true */ import("@editorjs/editorjs"),
                import("@editorjs/header"),
                import("@editorjs/attaches"),
                import("@editorjs/delimiter"),
                import("@editorjs/embed"),
                import("@editorjs/image"),
                import("@editorjs/nested-list"),
                import("@editorjs/quote"),
                import("@editorjs/table"),
                import("@editorjs/text-variant-tune"),
                import("@editorjs/underline"),
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
                ]) => {
                    const tools = {
                        header,
                        delimiter,
                        list,
                        quote,
                        table,
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
                                },
                                additionalRequestHeaders: {
                                    "X-CSRF-TOKEN": csrf,
                                },
                            },
                        };
                        tools["attaches"] = {
                            class: attaches,
                            config: {
                                endpoint: route('upload.store'),
                                additionalRequestHeaders: {
                                    "X-CSRF-TOKEN": csrf,
                                },
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
                            console.log(event.detail.target);
                            console.log(JSON.stringify(event.detail.target.config.data));
                            this.body = JSON.stringify(await api.saver.save());
                        },
                    });
                }
            );
        },

        async save() {
            return await this.editor.save();
        },
    });
