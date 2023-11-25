document.addEventListener("alpine:init", () => {
    Alpine.data("slimSelect", (placeholder) => ({
        selected: [],
        async init() {
            import("slim-select").then(({ default: SlimSelect }) => {
                new SlimSelect({
                    select: this.$el,
                    settings: {
                        placeholderText: placeholder ?? "",
                    },
                    events: {
                        afterChange: (values) => {
                            this.selected = values.map((value) => value.value);
                            if(!this.$el.multiple) this.selected = this.selected[0];
                        },
                    },
                });
            });
        },
    }));
});
