# Contributing

## Thank you

First off, let me sincerely thank you for being interested in contributing to this project. I started FACET-Acq for a single purpose, to provide high quality open source solutions to common business problems. Your interest in contributing shows how powerful this concept can be. By contributing to open source projects, in any capacity, is a fantastic and tangible step toward making the business environment a better place.

## Resources

- **Issues** we use [native GitHub issues](https://github.com/facet-acq/post-award/issues) to track project activities
- **Project Management** since ZenHub has such a tight integration with GitHub has does excellent support for Open Source projects, you can [see our ZenHub board](https://github.com/facet-acq/post-award/issues#boards?repos=107730020) here.
- **Chat** for the moment, GitHub issue comments should suffice. If need arises, I'm happy to go to Slack, Gitter or IRC as needed.
- **Road Map** check out the [FACET-Acq organization design repository](https://github.com/facet-acq/design) for a good idea of the goals of this program. There's also some [initial notes](https://github.com/facet-acq/design/blob/master/post_award.md) that show where post-award itself is going.

## Ways to contribute

All contributions are welcome! Please open an issue to discuss if you're not sure where to jump in.

### Business Intent/Product Management

While I can draw on my past experience in these processes and openly available research, my background  heavily leverages accounting, process and software engineering and system integration so if you're interested in helping to clarify (groom) of intent and business value and needs, you are most welcome! Entitlement, acquisitions, finance, contract management or program management experience are all welcome.

### Technical Contributions

This project is a large concept, but it is very achievable. To do so technical assistance is accepted for code, design, DevOps and documentation.

<<<<<<< HEAD
Please make sure that code contributions follow the [style guide](https://github.com/facet-acq/post-award/wiki/Style-Guide#coding-styles) and that PRs follow the [PR strategy](https://github.com/facet-acq/post-award/wiki/Style-Guide#pull-requests).
=======
## Git Strategy

### Branching

This project leverages the popular Git-Flow as a general rule. If you're not currently using it, consider [learning more about git flow](https://datasift.github.io/gitflow/IntroducingGitFlow.html).

_tl;dr_ all work is done in feature branches, these merge to develop which branches a release which is then merged back into both develop and master. Hotfixes are based on master and closed on merge to master and develop.

This method ensures that:

- the `master` branch has a tag for each commit layer, which matches production releases exactly
- the `develop` branch holds the latest features ready for testing and quality assurance
- each new feature is broken into a `features/[description]` branch for direct tracing of activities
- new release candidates are built in a `release/[semanticVersion]` branch to do last minute changes before releasing to production
  - version increments
  - dependency lock down/updates
- hotfixes are supported

With its convenient plugin for Mac and Windows development platforms, even with simple understanding of the CLI concepts, the convention is easy to follow.

### Pull Requests

All PRs

- should follow the style guidelines
- must maintain or increase test coverage
- reference the story/issue they address
- call out any new dependencies added by the PR
- check PR build results and resolve any issues
- be made against the `develop` branch, or explain special circumstances why they are made against another

### Commit messages

Commit messages should reference the story/issue addressed, and must include a brief summary of the change proposed (this should be about 72 characters in length). The summary should be followed with a paragraph description of the change, intent, and explanation of any decisions made as part of the commit. This helps frame the story and lead to more meaningful code review feedback. In this vein, a PR should consist of several small commits instead of one large one. Incremental progress is easier to follow and review and a more natural workflow.

### Merging

All merges _should_ be conducted as `rebase` actions. If you're new to rebase-ing or have unanswered questions [this introduction blog post is excellent](https://dev.to/maxwell_dev/the-git-rebase-introduction-i-wish-id-had). This practice maintains the overall revision tree. The workflow is slightly more complex, but the long term benefits make it worth it to learn. Check out [the workflow](https://randyfay.com/content/rebase-workflow-git) here.
>>>>>>> Add contributing file
