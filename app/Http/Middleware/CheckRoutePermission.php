<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoutePermission
{
    /**
     * Route to permission mapping
     * Maps route name patterns to required permissions
     */
    protected array $routePermissions = [
        // Projects
        'project.index' => 'projects-view',
        'project.show' => 'projects-view',
        'project.create' => 'projects-create',
        'project.store' => 'projects-create',
        'project.edit' => 'projects-edit',
        'project.update' => 'projects-edit',
        'project.delete' => 'projects-delete',
        'project.toggle-publish' => 'projects-edit',
        'project.toggle-home-feature' => 'projects-edit',
        'project.toggle-feasibility-studies' => 'projects-edit',
        'project.trashed' => 'projects-view',
        'project.restore' => 'projects-restore',
        'project.bulk-publish' => 'projects-edit',
        'project.bulk-home-status' => 'projects-edit',
        
        // Offers
        'offer.index' => 'offers-view',
        'offer.show' => 'offers-view',
        'offer.create' => 'offers-create',
        'offer.store' => 'offers-create',
        'offer.edit' => 'offers-edit',
        'offer.update' => 'offers-edit',
        'offer.delete' => 'offers-delete',
        'offer.toggle-publish' => 'offers-edit',
        'offer.toggle-home-feature' => 'offers-edit',
        'offer.toggle-feasibility-studies' => 'offers-edit',
        'offer.trashed' => 'offers-view',
        'offer.restore' => 'offers-restore',
        'offer.bulk-publish' => 'offers-edit',
        'offer.bulk-home-status' => 'offers-edit',
        
        // Services
        'service.index' => 'services-view',
        'service.show' => 'services-view',
        'service.create' => 'services-create',
        'service.store' => 'services-create',
        'service.edit' => 'services-edit',
        'service.update' => 'services-edit',
        'service.delete' => 'services-delete',
        'service.toggle-publish' => 'services-edit',
        'service.toggle-home-feature' => 'services-edit',
        'service.trashed' => 'services-view',
        'service.restore' => 'services-restore',
        
        // News
        'news-back.index' => 'news-view',
        'news-back.create' => 'news-create',
        'news-back.store' => 'news-create',
        'news-back.edit' => 'news-edit',
        'news-back.update' => 'news-edit',
        'news-back.delete' => 'news-delete',
        
        // News Categories
        'newscategories.index' => 'news-view',
        'newscategories.create' => 'news-create',
        'newscategories.store' => 'news-create',
        'newscategories.edit' => 'news-edit',
        'newscategories.update' => 'news-edit',
        'newscategories.delete' => 'news-delete',
        'newscategories.trashed' => 'news-view',
        'newscategories.restore' => 'news-restore',
        
        // Portfolios
        'portfolio.index' => 'portfolios-view',
        'portfolio.show' => 'portfolios-view',
        'portfolio.create' => 'portfolios-create',
        'portfolio.store' => 'portfolios-create',
        'portfolio.edit' => 'portfolios-edit',
        'portfolio.update' => 'portfolios-edit',
        'portfolio.delete' => 'portfolios-delete',
        'portfolio.trashed' => 'portfolios-view',
        'portfolio.restore' => 'portfolios-restore',
        
        // Sliders
        'slider.index' => 'sliders-view',
        'slider.create' => 'sliders-create',
        'slider.store' => 'sliders-create',
        'slider.edit' => 'sliders-edit',
        'slider.update' => 'sliders-edit',
        'slider.delete' => 'sliders-delete',
        'slider.toggle-status' => 'sliders-edit',
        'slider.update-orders' => 'sliders-edit',
        'slider.trashed' => 'sliders-view',
        'slider.restore' => 'sliders-restore',
        
        // Partners
        'partner.index' => 'partners-view',
        'partner.show' => 'partners-view',
        'partner.create' => 'partners-create',
        'partner.store' => 'partners-create',
        'partner.edit' => 'partners-edit',
        'partner.update' => 'partners-edit',
        'partner.delete' => 'partners-delete',
        'partner.update-order' => 'partners-edit',
        'partner.trashed' => 'partners-view',
        'partner.restore' => 'partners-restore',
        
        // Team
        'admin.team.index' => 'team-view',
        'admin.team.show' => 'team-view',
        'admin.team.create' => 'team-create',
        'admin.team.store' => 'team-create',
        'admin.team.edit' => 'team-edit',
        'admin.team.update' => 'team-edit',
        'admin.team.delete' => 'team-delete',
        'admin.team.trashed' => 'team-view',
        'admin.team.restore' => 'team-restore',
        'admin.team.update-display-order' => 'team-edit',
        'admin.team.update-board-order' => 'team-edit',
        
        // Interior Design Galleries
        'interior-design-gallery.index' => 'interior-design-galleries-view',
        'interior-design-gallery.show' => 'interior-design-galleries-view',
        'interior-design-gallery.create' => 'interior-design-galleries-create',
        'interior-design-gallery.store' => 'interior-design-galleries-create',
        'interior-design-gallery.edit' => 'interior-design-galleries-edit',
        'interior-design-gallery.update' => 'interior-design-galleries-edit',
        'interior-design-gallery.delete' => 'interior-design-galleries-delete',
        'interior-design-gallery.toggle-publish' => 'interior-design-galleries-edit',
        'interior-design-gallery.toggle-home' => 'interior-design-galleries-edit',
        'interior-design-gallery.bulk-publish' => 'interior-design-galleries-edit',
        'interior-design-gallery.bulk-home-status' => 'interior-design-galleries-edit',
        'interior-design-gallery.bulk-add' => 'interior-design-galleries-create',
        'interior-design-gallery.bulk-store' => 'interior-design-galleries-create',
        'interior-design-gallery.trashed' => 'interior-design-galleries-view',
        'interior-design-gallery.restore' => 'interior-design-galleries-restore',
        
        // Menus
        'admin.menu.index' => 'menus-view',
        'admin.menu.create' => 'menus-create',
        'admin.menu.store' => 'menus-create',
        'admin.menu.edit' => 'menus-edit',
        'admin.menu.update' => 'menus-edit',
        'admin.menu.delete' => 'menus-delete',
        'admin.menu.toggle-status' => 'menus-edit',
        'admin.menu.settings' => 'menus-edit',
        'admin.menu.settings.update' => 'menus-edit',
        'admin.menu.trashed' => 'menus-view',
        'admin.menu.restore' => 'menus-delete',
        'admin.menu.items' => 'menu-items-view',
        'admin.menu.item.create' => 'menu-items-create',
        'admin.menu.item.store' => 'menu-items-create',
        'admin.menu.item.edit' => 'menu-items-edit',
        'admin.menu.item.update' => 'menu-items-edit',
        'admin.menu.item.delete' => 'menu-items-delete',
        'admin.menu.item.toggle-status' => 'menu-items-edit',
        'admin.menu.items.trashed' => 'menu-items-view',
        'admin.menu.item.restore' => 'menu-items-delete',
        'admin.menu.items.update-order' => 'menu-items-edit',
        
        // Certificates
        'certificate.index' => 'certificates-view',
        'certificate.create' => 'certificates-create',
        'certificate.store' => 'certificates-create',
        'certificate.edit' => 'certificates-edit',
        'certificate.update' => 'certificates-edit',
        'certificate.delete' => 'certificates-delete',
        'certificate.toggle-status' => 'certificates-edit',
        'certificate.update-order' => 'certificates-edit',
        'certificate.trashed' => 'certificates-view',
        'certificate.restore' => 'certificates-delete',
        
        // About Information
        'about-information.index' => 'about-information-view',
        'about-information.update' => 'about-information-edit',
        
        // About Features
        'about-feature.index' => 'about-features-view',
        'about-feature.create' => 'about-features-create',
        'about-feature.store' => 'about-features-create',
        'about-feature.edit' => 'about-features-edit',
        'about-feature.update' => 'about-features-edit',
        'about-feature.delete' => 'about-features-delete',
        'about-feature.toggle-status' => 'about-features-edit',
        'about-feature.trashed' => 'about-features-view',
        'about-feature.restore' => 'about-features-delete',
        
        // About Custom Blocks
        'about-custom-block.index' => 'about-custom-blocks-view',
        'about-custom-block.create' => 'about-custom-blocks-create',
        'about-custom-block.store' => 'about-custom-blocks-create',
        'about-custom-block.edit' => 'about-custom-blocks-edit',
        'about-custom-block.update' => 'about-custom-blocks-edit',
        'about-custom-block.delete' => 'about-custom-blocks-delete',
        'about-custom-block.toggle-status' => 'about-custom-blocks-edit',
        'about-custom-block.trashed' => 'about-custom-blocks-view',
        'about-custom-block.restore' => 'about-custom-blocks-delete',
        
        // Contact Information
        'contact-information.index' => 'contact-information-view',
        'contact-information.update' => 'contact-information-edit',
        
        // Home Sections
        'home-sections.index' => 'home-sections-view',
        'home-sections.edit' => 'home-sections-edit',
        'home-sections.update' => 'home-sections-edit',
        'home-sections.toggle-status' => 'home-sections-edit',
        'home-sections.toggle-divider' => 'home-sections-edit',
        'home-sections.update-order' => 'home-sections-edit',
        'home-sections.move-up' => 'home-sections-edit',
        'home-sections.move-down' => 'home-sections-edit',
        'home-sections.delete' => 'home-sections-edit',
        'home-sections.trashed' => 'home-sections-view',
        'home-sections.restore' => 'home-sections-edit',
        
        // Home Projects Settings
        'home-project-settings.index' => 'home-projects-view',
        'home-project-settings.update' => 'home-projects-edit',
        'home-project-settings.update-order' => 'home-projects-edit',
        'home-project-settings.toggle-status' => 'home-projects-edit',
        'home-project-settings.bulk-update' => 'home-projects-edit',
        'home-project-settings.reset' => 'home-projects-edit',
        'home-project-settings.select-projects' => 'home-projects-edit',
        'home-project-settings.save-projects' => 'home-projects-edit',
        'home-project-settings.clear-projects' => 'home-projects-edit',
        
        // Page Banners
        'page-banner.index' => 'page-banners-view',
        'page-banner.create' => 'page-banners-edit',
        'page-banner.store' => 'page-banners-edit',
        'page-banner.edit' => 'page-banners-edit',
        'page-banner.update' => 'page-banners-edit',
        'page-banner.delete' => 'page-banners-edit',
        'page-banner.trashed' => 'page-banners-view',
        'page-banner.restore' => 'page-banners-edit',
        
        // Site Settings
        'site-settings.index' => 'settings-view',
        'site-settings.update-construction' => 'settings-edit',
        'site-settings.update-contact-forms' => 'settings-edit',
        
        // Users
        'users.index' => 'users-view',
        'users.create' => 'users-create',
        'users.store' => 'users-create',
        'users.edit' => 'users-edit',
        'users.update' => 'users-edit',
        'users.delete' => 'users-delete',
        'admin.users.roles.index' => 'users-view',
        'admin.users.roles.edit' => 'users-edit',
        'admin.users.roles.update' => 'users-edit',
        'admin.users.roles.permissions' => 'users-view',
        
        // Roles
        'admin.roles.index' => 'roles-view',
        'admin.roles.show' => 'roles-view',
        'admin.roles.create' => 'roles-create',
        'admin.roles.store' => 'roles-create',
        'admin.roles.edit' => 'roles-edit',
        'admin.roles.update' => 'roles-edit',
        'admin.roles.destroy' => 'roles-delete',
        'admin.roles.toggle-active' => 'roles-edit',
        'admin.roles.trashed' => 'roles-view',
        'admin.roles.restore' => 'roles-delete',
        'admin.roles.force-delete' => 'roles-delete',
        
        // Activity Logs
        'admin.activity-logs.index' => 'activity-logs-view',
        'admin.activity-logs.show' => 'activity-logs-view',
        'admin.activity-logs.clear-old' => 'activity-logs-delete',
        
        // Job Postings
        'job-posting.index' => 'job-postings-view',
        'job-posting.show' => 'job-postings-view',
        'job-posting.create' => 'job-postings-create',
        'job-posting.store' => 'job-postings-create',
        'job-posting.edit' => 'job-postings-edit',
        'job-posting.update' => 'job-postings-edit',
        'job-posting.delete' => 'job-postings-delete',
        'job-posting.trashed' => 'job-postings-view',
        'job-posting.restore' => 'job-postings-restore',

        // Job Applications
        'crm-job-applications.index' => 'job-applications-view',
        'crm-job-applications.download' => 'job-applications-view',

        // FAQs
        'faq.index' => 'services-view',
        'faq.create' => 'services-create',
        'faq.store' => 'services-create',
        'faq.edit' => 'services-edit',
        'faq.update' => 'services-edit',
        'faq.delete' => 'services-delete',
        'faq.trashed' => 'services-view',
        'faq.restore' => 'services-restore',
        
        // Home FAQs
        'homefaq.index' => 'home-sections-view',
        'homefaq.create' => 'home-sections-edit',
        'homefaq.store' => 'home-sections-edit',
        'homefaq.edit' => 'home-sections-edit',
        'homefaq.update' => 'home-sections-edit',
        'homefaq.delete' => 'home-sections-edit',
        'homefaq.trashed' => 'home-sections-view',
        'homefaq.restore' => 'home-sections-edit',
        
        // Home Blocks
        'homeblock.index' => 'home-sections-view',
        'homeblock.create' => 'home-sections-edit',
        'homeblock.store' => 'home-sections-edit',
        'homeblock.edit' => 'home-sections-edit',
        'homeblock.update' => 'home-sections-edit',
        'homeblock.delete' => 'home-sections-edit',
        'homeblock.trashed' => 'home-sections-view',
        'homeblock.restore' => 'home-sections-edit',
        
        // Cards
        'card.index' => 'home-sections-view',
        'card.create' => 'home-sections-edit',
        'card.store' => 'home-sections-edit',
        'card.edit' => 'home-sections-edit',
        'card.update' => 'home-sections-edit',
        'card.delete' => 'home-sections-edit',
        'card.trashed' => 'home-sections-view',
        'card.restore' => 'home-sections-edit',
        
        // Home Contact
        'homecontact.index' => 'home-sections-view',
        'homecontact.update' => 'home-sections-edit',
        
        // ==========================================
        // BASICDATA MODULE ROUTES
        // ==========================================
        
        // Project Types
        'projecttype.index' => 'project-types-view',
        'projecttype.create' => 'project-types-create',
        'projecttype.store' => 'project-types-create',
        'projecttype.edit' => 'project-types-edit',
        'projecttype.update' => 'project-types-edit',
        'projecttype.delete' => 'project-types-delete',
        'projecttype.trashed' => 'project-types-view',
        'projecttype.restore' => 'project-types-restore',
        
        // Engineering Categories
        'engineeringcategory.index' => 'engineering-categories-view',
        'engineeringcategory.show' => 'engineering-categories-view',
        'engineeringcategory.create' => 'engineering-categories-create',
        'engineeringcategory.store' => 'engineering-categories-create',
        'engineeringcategory.edit' => 'engineering-categories-edit',
        'engineeringcategory.update' => 'engineering-categories-edit',
        'engineeringcategory.delete' => 'engineering-categories-delete',
        'engineeringcategory.trashed' => 'engineering-categories-view',
        'engineeringcategory.restore' => 'engineering-categories-restore',
        
        // Engineering Sub Categories
        'engineeringsubcategory.index' => 'engineering-sub-categories-view',
        'engineeringsubcategory.show' => 'engineering-sub-categories-view',
        'engineeringsubcategory.create' => 'engineering-sub-categories-create',
        'engineeringsubcategory.store' => 'engineering-sub-categories-create',
        'engineeringsubcategory.edit' => 'engineering-sub-categories-edit',
        'engineeringsubcategory.update' => 'engineering-sub-categories-edit',
        'engineeringsubcategory.delete' => 'engineering-sub-categories-delete',
        'engineeringsubcategory.trashed' => 'engineering-sub-categories-view',
        'engineeringsubcategory.restore' => 'engineering-sub-categories-restore',
        
        // Project Styles
        'projectstyle.index' => 'project-styles-view',
        'projectstyle.create' => 'project-styles-create',
        'projectstyle.store' => 'project-styles-create',
        'projectstyle.edit' => 'project-styles-edit',
        'projectstyle.update' => 'project-styles-edit',
        'projectstyle.delete' => 'project-styles-delete',
        'projectstyle.trashed' => 'project-styles-view',
        'projectstyle.restore' => 'project-styles-restore',
        
        // Amenities
        'amenity.index' => 'amenities-view',
        'amenity.create' => 'amenities-create',
        'amenity.store' => 'amenities-create',
        'amenity.edit' => 'amenities-edit',
        'amenity.update' => 'amenities-edit',
        'amenity.delete' => 'amenities-delete',
        'amenity.trashed' => 'amenities-view',
        'amenity.restore' => 'amenities-restore',
        
        // Building Components
        'buildingcomponent.index' => 'building-components-view',
        'buildingcomponent.create' => 'building-components-create',
        'buildingcomponent.store' => 'building-components-create',
        'buildingcomponent.edit' => 'building-components-edit',
        'buildingcomponent.update' => 'building-components-edit',
        'buildingcomponent.delete' => 'building-components-delete',
        'buildingcomponent.trashed' => 'building-components-view',
        'buildingcomponent.restore' => 'building-components-restore',
        
        // Floor Components
        'floorcomponent.index' => 'floor-components-view',
        'floorcomponent.create' => 'floor-components-create',
        'floorcomponent.store' => 'floor-components-create',
        'floorcomponent.edit' => 'floor-components-edit',
        'floorcomponent.update' => 'floor-components-edit',
        'floorcomponent.delete' => 'floor-components-delete',
        'floorcomponent.trashed' => 'floor-components-view',
        'floorcomponent.restore' => 'floor-components-restore',
        
        // Income Components
        'incomecomponent.index' => 'income-components-view',
        'incomecomponent.create' => 'income-components-create',
        'incomecomponent.store' => 'income-components-create',
        'incomecomponent.edit' => 'income-components-edit',
        'incomecomponent.update' => 'income-components-edit',
        'incomecomponent.delete' => 'income-components-delete',
        'incomecomponent.trashed' => 'income-components-view',
        'incomecomponent.restore' => 'income-components-restore',
        
        // Length Components
        'lengthcomponent.index' => 'length-components-view',
        'lengthcomponent.create' => 'length-components-create',
        'lengthcomponent.store' => 'length-components-create',
        'lengthcomponent.edit' => 'length-components-edit',
        'lengthcomponent.update' => 'length-components-edit',
        'lengthcomponent.delete' => 'length-components-delete',
        'lengthcomponent.trashed' => 'length-components-view',
        'lengthcomponent.restore' => 'length-components-restore',
        'lengthcomponent.get-building-components' => 'length-components-view',
        
        // Currencies
        'currency.index' => 'currencies-view',
        'currency.create' => 'currencies-create',
        'currency.store' => 'currencies-create',
        'currency.edit' => 'currencies-edit',
        'currency.update' => 'currencies-edit',
        'currency.delete' => 'currencies-delete',
        'currency.trashed' => 'currencies-view',
        'currency.restore' => 'currencies-restore',
        
        // Specifications
        'specification.index' => 'specifications-view',
        'specification.create' => 'specifications-create',
        'specification.store' => 'specifications-create',
        'specification.edit' => 'specifications-edit',
        'specification.update' => 'specifications-edit',
        'specification.delete' => 'specifications-delete',
        'specification.trashed' => 'specifications-view',
        'specification.restore' => 'specifications-restore',
        
        // Substation Rooms
        'substationroom.index' => 'substation-rooms-view',
        'substationroom.create' => 'substation-rooms-create',
        'substationroom.store' => 'substation-rooms-create',
        'substationroom.edit' => 'substation-rooms-edit',
        'substationroom.update' => 'substation-rooms-edit',
        'substationroom.delete' => 'substation-rooms-delete',
        'substationroom.trashed' => 'substation-rooms-view',
        'substationroom.restore' => 'substation-rooms-restore',
        
        // Pumps Rooms
        'pumpsroom.index' => 'pumps-rooms-view',
        'pumpsroom.create' => 'pumps-rooms-create',
        'pumpsroom.store' => 'pumps-rooms-create',
        'pumpsroom.edit' => 'pumps-rooms-edit',
        'pumpsroom.update' => 'pumps-rooms-edit',
        'pumpsroom.delete' => 'pumps-rooms-delete',
        'pumpsroom.trashed' => 'pumps-rooms-view',
        'pumpsroom.restore' => 'pumps-rooms-restore',
        
        // Feasibility Study Components
        'feasibilitystudycomponent.index' => 'feasibility-study-components-view',
        'feasibilitystudycomponent.create' => 'feasibility-study-components-create',
        'feasibilitystudycomponent.store' => 'feasibility-study-components-create',
        'feasibilitystudycomponent.edit' => 'feasibility-study-components-edit',
        'feasibilitystudycomponent.update' => 'feasibility-study-components-edit',
        'feasibilitystudycomponent.delete' => 'feasibility-study-components-delete',
        'feasibilitystudycomponent.trashed' => 'feasibility-study-components-view',
        'feasibilitystudycomponent.restore' => 'feasibility-study-components-restore',
        
        // Portfolio Types
        'portfoliotype.index' => 'portfolio-types-view',
        'portfoliotype.create' => 'portfolio-types-create',
        'portfoliotype.store' => 'portfolio-types-create',
        'portfoliotype.edit' => 'portfolio-types-edit',
        'portfoliotype.update' => 'portfolio-types-edit',
        'portfoliotype.delete' => 'portfolio-types-delete',
        'portfoliotype.trashed' => 'portfolio-types-view',
        'portfoliotype.restore' => 'portfolio-types-restore',
        
        // Job Titles
        'jobtitle.index' => 'job-titles-view',
        'jobtitle.create' => 'job-titles-create',
        'jobtitle.store' => 'job-titles-create',
        'jobtitle.edit' => 'job-titles-edit',
        'jobtitle.update' => 'job-titles-edit',
        'jobtitle.delete' => 'job-titles-delete',
        'jobtitle.trashed' => 'job-titles-view',
        'jobtitle.restore' => 'job-titles-restore',
        
        // Job Categories
        'jobcategory.index' => 'job-categories-view',
        'jobcategory.create' => 'job-categories-create',
        'jobcategory.store' => 'job-categories-create',
        'jobcategory.edit' => 'job-categories-edit',
        'jobcategory.update' => 'job-categories-edit',
        'jobcategory.delete' => 'job-categories-delete',
        'jobcategory.trashed' => 'job-categories-view',
        'jobcategory.restore' => 'job-categories-restore',
        
        // Ranks
        'rank.index' => 'ranks-view',
        'rank.create' => 'ranks-create',
        'rank.store' => 'ranks-create',
        'rank.edit' => 'ranks-edit',
        'rank.update' => 'ranks-edit',
        'rank.delete' => 'ranks-delete',
        'rank.trashed' => 'ranks-view',
        'rank.restore' => 'ranks-restore',
        
        // Languages
        'language.index' => 'languages-view',
        'language.edit' => 'languages-edit',
        'language.update' => 'languages-edit',
        
        // Emirates
        'emirate.index' => 'emirates-view',
        'emirate.show' => 'emirates-view',
        'emirate.create' => 'emirates-create',
        'emirate.store' => 'emirates-create',
        'emirate.edit' => 'emirates-edit',
        'emirate.update' => 'emirates-edit',
        'emirate.delete' => 'emirates-delete',
        'emirate.trashed' => 'emirates-view',
        'emirate.restore' => 'emirates-restore',
        'emirate.toggle-primary' => 'emirates-edit',
        
        // Offer Categories
        'offercategory.index' => 'offer-categories-view',
        'offercategory.show' => 'offer-categories-view',
        'offercategory.create' => 'offer-categories-create',
        'offercategory.store' => 'offer-categories-create',
        'offercategory.edit' => 'offer-categories-edit',
        'offercategory.update' => 'offer-categories-edit',
        'offercategory.delete' => 'offer-categories-delete',
        'offercategory.trashed' => 'offer-categories-view',
        'offercategory.restore' => 'offer-categories-restore',
        
        // Offer Sub Categories
        'offersubcategory.index' => 'offer-sub-categories-view',
        'offersubcategory.show' => 'offer-sub-categories-view',
        'offersubcategory.create' => 'offer-sub-categories-create',
        'offersubcategory.store' => 'offer-sub-categories-create',
        'offersubcategory.edit' => 'offer-sub-categories-edit',
        'offersubcategory.update' => 'offer-sub-categories-edit',
        'offersubcategory.delete' => 'offer-sub-categories-delete',
        'offersubcategory.trashed' => 'offer-sub-categories-view',
        'offersubcategory.restore' => 'offer-sub-categories-restore',
        
        // Interior Categories
        'interiorcategory.index' => 'interior-categories-view',
        'interiorcategory.show' => 'interior-categories-view',
        'interiorcategory.create' => 'interior-categories-create',
        'interiorcategory.store' => 'interior-categories-create',
        'interiorcategory.edit' => 'interior-categories-edit',
        'interiorcategory.update' => 'interior-categories-edit',
        'interiorcategory.delete' => 'interior-categories-delete',
        'interiorcategory.trashed' => 'interior-categories-view',
        'interiorcategory.restore' => 'interior-categories-delete',
        
        // Basicdata Dashboard
        'Basicdata' => 'dashboard-view',

        // ==========================================
        // CRM MODULE ROUTES
        // ==========================================

        // CRM Dashboard
        'CRM' => 'crm-dashboard-view',

        // Customers
        'crm-customers.index' => 'customers-view',
        'crm-customers.show' => 'customers-view',
        'crm-customers.live-search' => 'customers-view',
        'crm-customers.export-report' => 'customers-view',
        'crm-customers.assign-agent' => 'customers-edit',
        'crm-customers.unassign-agent' => 'customers-edit',
        'crm-customers.store-comment' => 'customers-edit',
        'crm-customers.delete-comment' => 'customers-edit',
        'crm-customers.send-email' => 'customers-send_email',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        // Defense in depth: only staff accounts may reach admin/CRM routes.
        // The `staff` middleware also enforces this at the route-group level.
        if (!$user->isStaff()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Forbidden.'], 403);
            }

            return redirect()->route('account.dashboard')
                ->with('error', 'This area is restricted to staff accounts.');
        }

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        $routeName = $request->route()->getName();

        if (!$routeName) {
            return $next($request);
        }

        if (isset($this->routePermissions[$routeName])) {
            $requiredPermission = $this->routePermissions[$routeName];
            
            if (!$user->hasPermission($requiredPermission)) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'error' => 'You do not have permission to perform this action.',
                        'required_permission' => $requiredPermission
                    ], 403);
                }
                
                return redirect()->route('Admin')
                    ->with('error', 'You do not have permission to access this page.');
            }
        }

        return $next($request);
    }
}
