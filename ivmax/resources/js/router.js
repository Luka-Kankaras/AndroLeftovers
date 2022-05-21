import VueRouter from "vue-router";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/admin/home",
            name: "admin.home",
            component: () =>
                import(
                    "@admin/dashboard/Home"
                )
        },
        {
            path: "/admin/products",
            name: "products",
            component: () =>
                import(
                    "@admin/cms/products/ProductsIndex"
                )
        },
        {
            path: "/admin/posts",
            name: "posts",
            component: () =>
                import(
                    "@admin/cms/posts/PostsIndex"
                )
        },
        {
            path: "/admin/tags",
            name: "tags",
            component: () =>
                import(
                    "@admin/cms/tags/TagsIndex"
                )
        },
        {
            path: "/admin/company",
            name: "company",
            component: () =>
                import(
                    "@admin/cms/company/CompanyIndex"
                )
        },
        {
            path: "/admin/languages",
            name: "languages",
            component: () =>
                import(
                    "@admin/cms/languages/LanguagesIndex"
                )
        },
        {
            path: "/admin/team",
            name: "team",
            component: () =>
                import(
                    "@admin/cms/team/TeamIndex"
                )
        },
        {
            path: "/admin/members",
            name: "members",
            component: () =>
                import(
                    "@admin/cms/members/MembersIndex"
                )
        },
        {
            path: "/admin/general-info",
            name: "general-info",
            component: () =>
                import(
                    "@admin/cms/info/GeneralInfoIndex"
                )
        },
        {
            path: "/admin/info-category",
            name: "info-category",
            component: () =>
                import(
                    "@admin/cms/info-categories/InfoCategoriesIndex"
                )
        },
        {
            path: "/admin/faqs",
            name: "faqs",
            component: () =>
                import(
                    "@admin/cms/faqs/FaqsIndex"
                )
        },
        {
            path: "/admin/contact",
            name: "contact",
            component: () =>
                import(
                    "@admin/cms/messages/MessagesIndex"
                )
        },
        {
            path: "/admin/users",
            name: "users",
            component: () =>
                import(
                    "@admin/users/UsersIndex"
                )
        },
        {
            path: "/admin/colors",
            name: "colors",
            component: () =>
                import(
                    "@admin/cms/colors/ColorIndex"
                )
        },
        {
            path: "/admin/types",
            name: "types",
            component: () =>
                import(
                    "@admin/cms/types/TypesIndex"
                )
        },
        {
            path: "/admin/homepage",
            name: "homepage",
            component: () =>
                import(
                    "@admin/cms/homepage/HomepageIndex"
                )
        },
        {
            path: "/admin/testimonial",
            name: "testimonial",
            component: () =>
                import(
                    "@admin/cms/testimonials/TestimonialIndex"
                )
        },
        {
            path: "/admin/translations",
            name: "translations",
            component: () =>
                import(
                    "@admin/cms/translations/TranslationsIndex"
                )
        },
        {
            path: "/admin/footer",
            name: "footer",
            component: () =>
                import(
                    "@admin/cms/footer/FooterIndex"
                )
        },
        {
            path: "/admin/newsletter",
            name: "newsletter",
            component: () =>
                import(
                    "@admin/cms/newsletter/NewsletterIndex"
                )
        },
        {
            path: "/admin",
            name: "admin",
            redirect: "/admin/home",
        },
    ]
});

export default router;
